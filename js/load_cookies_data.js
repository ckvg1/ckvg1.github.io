//Skrypt sluzy do pobierania nazw z cookie (pietro0,1,2 lub 3) i wpisaniu ich do odpowiednich divow na stronie, tak zeby biura byly podpisane
// nazwami ustawionymi przez uzytkownika

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i].trim();
    if (c.indexOf(name) === 0) {
      return c.substring(name.length);
    }
  }
  return "";
}

// Pobranie i parsowanie ciasteczka
function setRoomNames(pietro) {
  const cookie = getCookie(pietro);
  let parsedCookie = {};
  if (cookie) {
    parsedCookie = JSON.parse(cookie);
  } else {
    console.log("Ciasteczko nie istnieje!");
  }

  // Ustawianie nazw w divach
  document.querySelectorAll(".nazwaBiura").forEach((div) => {
    const id = div.id.replace("nazwa", "");

    if (id.endsWith("_2") && id.length > 4) {
      // To jest "drugi" div — kopiujemy nazwę z poprzednika
      const mainId = id.replace("_2", "");
      div.innerText = parsedCookie["r" + mainId] || "Brak nazwy";
    } else {
      // To jest główny div — ustawiamy z cookies
      div.innerText = parsedCookie["r" + id] || "Brak nazwy";
    }
  });
}
