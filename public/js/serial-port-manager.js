/**
 * Serial Port Manager - Gọn gàng và đơn giản
 * Quản lý kết nối serial port và gửi lệnh thanh toán
 */
class SerialPortManager {
    constructor() {
        this.port = null;
        this.savedPort = localStorage.getItem('savedPort');
        this.baudRate = 115200;

        // Lấy USB ID từ localStorage hoặc dùng giá trị mặc định
        this.targetUsbDevice = this.getTargetUsbDevice();
    }

    /**
     * Lấy USB ID mục tiêu từ localStorage hoặc dùng giá trị mặc định
     */
    getTargetUsbDevice() {
        const savedTargetDevice = localStorage.getItem('targetUsbDevice');
        if (savedTargetDevice) {
            try {
                return JSON.parse(savedTargetDevice);
            } catch (error) {
                console.log('Error parsing saved target device:', error);
            }
        }

        // Giá trị mặc định nếu chưa có trong localStorage
        return {
            usbVendorId: 6790,
            usbProductId: 29987
        };
    }

    /**
     * Lưu USB ID mục tiêu vào localStorage
     */
    saveTargetUsbDevice(usbVendorId, usbProductId) {
        const targetDevice = {
            usbVendorId: usbVendorId,
            usbProductId: usbProductId
        };
        localStorage.setItem('targetUsbDevice', JSON.stringify(targetDevice));
        this.targetUsbDevice = targetDevice;
    }

    /**
     * Khởi tạo port (tự động kết nối lại hoặc chọn mới)
     */
    async initializePort() {
        // Thử tìm thiết bị mục tiêu trong các port đã được cấp quyền
        const targetPort = await this.findTargetDevice();
        if (targetPort) {
            this.port = targetPort;
            try {
                await this.port.open({ baudRate: this.baudRate });
                this.showStatus('Đã tự động kết nối với thiết bị mục tiêu!');
                return true;
            } catch (error) {
                console.log('Cannot open target device:', error);
                this.port = null;
            }
        }

        // Nếu không tìm thấy thiết bị mục tiêu, thử kết nối lại với port đã lưu
        if (this.savedPort && !this.port) {
            try {
                const ports = await navigator.serial.getPorts();
                const savedPortInfo = JSON.parse(this.savedPort);

                const existingPort = ports.find(p =>
                    p.getInfo().usbVendorId === savedPortInfo.usbVendorId &&
                    p.getInfo().usbProductId === savedPortInfo.usbProductId
                );

                if (existingPort) {
                    this.port = existingPort;
                    await this.port.open({ baudRate: this.baudRate });
                    this.showStatus('Đã kết nối lại với port đã lưu!');
                    return true;
                }
            } catch (error) {
                console.log('Cannot reconnect to saved port:', error);
            }
        }

        return await this.requestNewPort();
    }

    /**
     * Tìm thiết bị mục tiêu trong các port đã được cấp quyền
     */
    async findTargetDevice() {
        try {
            const ports = await navigator.serial.getPorts();

            for (const port of ports) {
                const portInfo = port.getInfo();

                if (portInfo.usbVendorId === this.targetUsbDevice.usbVendorId &&
                    portInfo.usbProductId === this.targetUsbDevice.usbProductId) {
                    return port;
                }
            }

            console.log('Target device not found in authorized ports');
            return null;
        } catch (error) {
            console.error('Error finding target device:', error);
            return null;
        }
    }

    /**
     * Chọn port mới
     */
    async requestNewPort() {
        try {
            this.port = await navigator.serial.requestPort();
            await this.port.open({ baudRate: this.baudRate });

            const portInfo = this.port.getInfo();
            localStorage.setItem('savedPort', JSON.stringify(portInfo));

            // Lưu USB ID của thiết bị mới làm thiết bị mục tiêu
            if (portInfo.usbVendorId && portInfo.usbProductId) {
                this.saveTargetUsbDevice(portInfo.usbVendorId, portInfo.usbProductId);
                this.showStatus('Đã chọn và lưu thiết bị mới làm mục tiêu!');
            } else {
                this.showStatus('Đã chọn và lưu port mới!');
            }
            return true;
        } catch (error) {
            this.showStatus('Lỗi khi chọn cổng: ' + error.message, true);
            this.port = null;
            return false;
        }
    }

    /**
     * Gửi lệnh qua serial port
     */
    async sendCommand(command) {
        if (!command) {
            this.showStatus('Vui lòng nhập lệnh!', true);
            return false;
        }

        if (!this.port) {
            const initialized = await this.initializePort();
            if (!initialized) return false;
        }

        try {
            const encoder = new TextEncoder();
            const writer = this.port.writable.getWriter();
            await writer.write(encoder.encode(command + '\r\n'));
            writer.releaseLock();
            this.showStatus('Đã gửi lệnh thành công!');
            return true;
        } catch (error) {
            this.showStatus('Lỗi khi gửi lệnh: ' + error.message, true);
            return false;
        }
    }

    /**
     * Gửi lệnh mở giao diện chuyển khoản
     */
    async turnOnLightQRCode() {
        const command = 'BL(0);';
        return await this.sendCommand(command);
    }

    /**
     * Gửi lệnh mở giao diện chuyển khoản
     */
    async mainMenuQRCode() {
        await this.turnOnLightQRCode();
        const command = 'JUMP(0);';
        return await this.sendCommand(command);
    }

    /**
     * Gửi lệnh mở giao diện chuyển khoản
     */
    async turnOffQRCode() {
        const command = 'BL(255);';
        return await this.sendCommand(command);
    }

    /**
     * Gửi lệnh quay về menu chính
     */
    async backToMainMenu() {
        await this.turnOnLightQRCode();
        const command = 'JUMP(1);';
        return await this.sendCommand(command);
    }

    /**
     * Gửi lệnh thanh toán với mã QR
     */
    async sendPaymentCommand(qrCode) {
        await this.backToMainMenu();

        const CRC16 = qrCode.detail[0];
        const bankName = qrCode.detail[1];
        const accountNumber = qrCode.detail[2];
        const amount = qrCode.detail[3];

        console.log(CRC16, bankName, accountNumber, amount);
        
        const command = `QBAR(0,${CRC16});SET_TXT(0, ${bankName});SET_TXT(1,STK:${accountNumber});SET_TXT(2,${amount});`;
        return await this.sendCommand(command);
    }

    /**
     * Khởi tạo và gửi lệnh chuyển khoản
     */
    async initializeAndSendBankTransfer() {

        if (!this.port) {
            const initialized = await this.initializePort();
            if (!initialized) {
                this.showStatus('Không thể khởi tạo port!', true);
                return false;
            }
        }

        return await this.sendBankTransferCommand();
    }

    /**
     * Gửi lệnh thanh toán với mã QR từ Livewire
     */
    async processPayment(qrCode) {

        if (!this.port) {
            const initialized = await this.initializePort();
            if (!initialized) {
                this.showStatus('Không thể khởi tạo port!', true);
                return false;
            }
        }

        return await this.sendPaymentCommand(qrCode);
    }

    /**
     * Hiển thị trạng thái
     */
    showStatus(message, isError = false) {
        const status = document.getElementById('status');
        if (status) {
            status.textContent = message;
            status.style.color = isError ? 'red' : 'green';
        }
    }

    /**
     * Xóa port đã lưu
     */
    clearSavedPort() {
        localStorage.removeItem('savedPort');
        localStorage.removeItem('targetUsbDevice');
        if (this.port) {
            this.port.close();
            this.port = null;
        }
        // Reset về giá trị mặc định
        this.targetUsbDevice = {
            usbVendorId: 6790,
            usbProductId: 29987
        };
        this.showStatus('Đã xóa port và thiết bị mục tiêu đã lưu!');
    }

    /**
     * Kiểm tra có port đã lưu
     */
    hasSavedPort() {
        return !!this.savedPort;
    }

    /**
     * Đóng port
     */
    async closePort() {
        if (this.port) {
            try {
                await this.port.close();
                this.port = null;
                this.showStatus('Đã đóng kết nối port!');
            } catch (error) {
                console.error('Error closing port:', error);
            }
        }
    }

    /**
     * Tự động kết nối khi trang load (nếu có thiết bị mục tiêu)
     */
    async autoConnect() {
        const success = await this.initializePort();

        return success;
    }

    /**
     * Lấy thông tin thiết bị mục tiêu hiện tại
     */
    getCurrentTargetDevice() {
        return this.targetUsbDevice;
    }
}

// Tạo instance global
window.serialPortManager = new SerialPortManager();

// Tự động kết nối khi trang load
document.addEventListener('DOMContentLoaded', () => {
    // Delay một chút để đảm bảo trang đã load xong
    setTimeout(() => {
        window.serialPortManager.autoConnect();
    }, 1000);
});

// Export cho module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = SerialPortManager;
}
