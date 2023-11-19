const openNotification = () => {
    const notification = document.getElementById("notification");
    setTimeout(() => {
        if (notification) notification.style.display = "none";
    }, 3000);
};

document.addEventListener("DOMContentLoaded", function() {
    openNotification()
});