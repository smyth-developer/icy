import Sortable from 'sortablejs';
window.Sortable = Sortable;

import './audio';

// Loại bỏ con trỏ nhấp nháy không cần thiết
document.addEventListener('DOMContentLoaded', function() {
    // Blur any focused element khi trang load
    if (document.activeElement && document.activeElement !== document.body) {
        document.activeElement.blur();
    }
    
    // Thêm event listener để blur khi click vào body
    document.body.addEventListener('click', function(e) {
        if (e.target === document.body) {
            document.activeElement.blur();
        }
    });
});
