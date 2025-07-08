const apiBase = "http://localhost/Exam-S4/ws";

function ajax(method, url, data, successCallback, errorCallback) {
  const xhr = new XMLHttpRequest();
  const fullUrl = apiBase + url;

  xhr.open(method, fullUrl, true);

  // Toujours définir le Content-Type pour JSON
  if (method !== "GET") {
    xhr.setRequestHeader("Content-Type", "application/json");
  }

  xhr.onreadystatechange = () => {
    if (xhr.readyState === 4) {
      if (xhr.status >= 200 && xhr.status < 300) {
        try {
          const response = xhr.responseText
            ? JSON.parse(xhr.responseText)
            : null;
          successCallback?.(response);
        } catch (e) {
          errorCallback?.("Invalid JSON response", xhr.status);
        }
      } else {
        errorCallback?.(xhr.statusText || "Erreur serveur", xhr.status);
      }
    }
  };

  xhr.onerror = () => {
    errorCallback?.("Erreur réseau", 0);
  };

  // Convertir les données en JSON pour les méthodes non-GET
  const sendData = method === "GET" ? null : JSON.stringify(data);
  xhr.send(sendData);
}
