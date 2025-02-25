function create_notification(text) {
  var notification = document.createElement('div');
  notification.classList.add('notification');
  notification.textContent = text;
  document.body.appendChild(notification);

  setTimeout(() => {
    notification.style.opacity = 1;
    notification.style.transform = 'translate(-50%, +32px)';
    setTimeout(() => {
      notification.style.opacity = 0;
      notification.style.transform = 'translate(-50%,-100px)';
      setTimeout(() => {
        notification.remove();
      }, 1000);
    }, 3000)
  }, 300)


}

export { create_notification };
