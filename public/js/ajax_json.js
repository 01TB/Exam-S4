function ajax(method, url, data, successCallback, errorCallback) {
  const xhr = new XMLHttpRequest();
  xhr.open(method, url, true);
  if (method === "POST") {
    xhr.setRequestHeader("Content-Type", "application/json");
  }
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status >= 200 && xhr.status < 300) {
        try {
          const response = JSON.parse(xhr.responseText);
          successCallback(response);
        } catch (e) {
          errorCallback("Invalid response from server");
        }
      } else {
        errorCallback(xhr.responseText || "Server error");
      }
    }
  };
  xhr.send(data);
}
