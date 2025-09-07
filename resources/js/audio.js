// resources/js/audio.js
document.addEventListener("DOMContentLoaded", function () {
    const soundSuccess = new Audio("/storage/audio/success.mp3");
    const soundError = new Audio("/storage/audio/error.mp3");
    const soundBanking = new Audio("/storage/audio/banking-success.mp3");

    window.playSound = {
        success: () => soundSuccess.play(),
        error: () => soundError.play(),
        banking: () => soundBanking.play(),
    };
});
