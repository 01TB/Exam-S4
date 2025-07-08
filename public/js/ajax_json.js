function ajax(method, url, data, successCallback, errorCallback) {
  const xhr = new XMLHttpRequest();
  const fullUrl = apiBase + url;

  xhr.open(method, fullUrl, true);

  if (method !== "GET" && data) {
    // Changement du Content-Type pour JSON
    xhr.setRequestHeader("Content-Type", "application/json");
  }

  xhr.onreadystatechange = () => {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
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

  // Modification pour envoyer les données en JSON
  let postData = null;
  if (method !== "GET" && data) {
    if (typeof data === "object") {
      // Convertit l'objet en chaîne JSON
      postData = JSON.stringify(data);
    } else {
      // Si ce n'est pas un objet, on envoie tel quel (mais ce n'est pas recommandé pour du JSON)
      postData = data;
    }
  }

  xhr.send(method === "GET" ? null : postData);
}
