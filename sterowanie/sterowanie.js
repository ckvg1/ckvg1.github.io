//sterowanie.js - sktrypt do obsługi sterowania w aplikacji

/* 
  Funkcja moze sie przydac przy wysyłaniu żądań do serwera
  np. do opóźnienia wysyłania żądań, aby uniknąc przeciążenia serwera 
  uzycie: await delay(1000); // opóźnienie 1 sekundy
 */
function delay(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}

const alertBox = document.getElementById("alertBox"); // element do wyświetlania alertów

/*
  flaga do sprawdzania, czy uzytkownik wyslal juz jakies zadanie do serwera (zeby uniknąć wielokrotnego wysyłania tego samego żądania)
  np. przy wielokrotnym kliknięciu na przycisk włączania
 */
let isFetchingLight = false;
let isFetchingBlinds = false;

// funkcja do ponownego nawiązania połączenia z serwerem
function reconnectStreams() {
  location.reload(); // odświeżenie strony w celu ponownego nawiązania połączenia z serwerem
}
let no_internet = "../img_main/icony/no-internet.png";

/*
  Funkcja do wyświetlania alertów
  przyjmuje opcjonalny parametr message, który jest treścią alertu
  jeśli nie zostanie podany, wyświetli domyślny komunikat 
 */
function showAlert(
  message = "<strong>Uwaga</strong> - Nie udało się połączyć z serwerem. <img src='" +
    no_internet +
    "' style='width: 20px; height: 20px; vertical-align: middle;' /> <a onclick='window.location.reload()' style='cursor: pointer; margin-left: 20px'> <strong> spróbuj ponownie </strong> </a>"
) {
  if (document.body.classList.contains("ciemny")) {
    // sprawdzenie, czy strona jest w trybie ciemnym
    no_internet = "../img_main/icony/no-internet-dark.png";
  } else {
    no_internet = "../img_main/icony/no-internet.png";
  }
  document.getElementsByClassName("main_image")[0].style.opacity = "0.35"; // pełna widoczność
  document.getElementsByClassName("main_image")[0].style.pointerEvents = "none"; // aktywacja interakcji
  document.getElementsByClassName("main_image")[0].style.cursor = "default"; // wskaźnik "ręka"
  alertBox.style.display = "block";
  document.querySelector(".oaerror").innerHTML = message;
  translatePage(getCookie("lang") || "pl"); // tłumaczenie strony na język ustawiony w ciasteczkach lub domyślnie na polski
}

function hideAlert() {
  alertBox.style.display = "none"; // ukrycie alertu
  document.getElementsByClassName("main_image")[0].style.opacity = "1"; // pełna widoczność
  document.getElementsByClassName("main_image")[0].style.pointerEvents = "auto"; // aktywacja interakcji
  document.getElementsByClassName("main_image")[0].style.cursor = "default"; // wskaźnik "ręka"
}

// Po zaladowaniu strony, nawiązanie połączenia z serwerem i rozpoczęcie nasłuchiwania na zdarzenia
addEventListener("DOMContentLoaded", () => {
  showAlert(
    " Trwa łączenie z PLC. <img src='../img_main/icony/loading.gif' style='width: 30px; height: 30px; vertical-align: middle; margin-left: 10px' />"
  );
  const connectionTimeout = setTimeout(() => {
    showAlert();
  }, 10000); // ustawienie limitu czasu na 10 sekund na połączenie z serwerem

  // Nawiązanie połączenia z serwerem i rozpoczęcie nasłuchiwania na zdarzenia
  const swiatlaStream = new EventSource(
    `${window.config.apiBaseUrl}/stream/swiatla`
  );
  swiatlaStream.onmessage = (event) => {
    clearTimeout(connectionTimeout); // jezeli dostalismy dane, to anulujemy timeout
    const dane = JSON.parse(event.data);
    Object.entries(dane).forEach(([id, wartosc]) => {
      const el = document.getElementById(id);
      if (el) {
        if (el.id.slice(0, 5) == "out_l") {
          let nazwa_pliku =
            localStorage.getItem("theme") == "ciemny-motyw"
              ? "bulb_of-dark.png"
              : "bulb_of.png";
          // sprawdzenie, czy element jest wyjściem światła
          el.src = wartosc // w zalezonosci od wartosci, ustawiamy odpowiedni obrazek
            ? `../img_main/icony/bulb_on.png`
            : `../img_main/icony/${nazwa_pliku}`;
        }
      }
    });
  };
  const temperaturaStream = new EventSource(
    `${window.config.apiBaseUrl}/stream/temperatura`
  );
  temperaturaStream.onmessage = (event) => {
    clearTimeout(connectionTimeout);
    const dane = JSON.parse(event.data);

    Object.entries(dane).forEach(([id, wartosc]) => {
      const el = document.getElementById(id);
      if (el) el.innerText = `${wartosc.toFixed(1)} °C`; // ustawienie wartości temperatury z dokładnością do 1 miejsca po przecinku
    });
  };

  const roletyStream = new EventSource(
    `${window.config.apiBaseUrl}/stream/rolety`
  );
  roletyStream.onmessage = (event) => {
    clearTimeout(connectionTimeout);
    const dane = JSON.parse(event.data);
    Object.entries(dane).forEach(([id, wartosc]) => {
      console.log("Rolety id:", id, "wartosc:", wartosc);
      const el = document.getElementById(
        id.split("_")[1] + "_" + id.split("_")[2] + "_" + id.split("_")[3]
      );
      if (el) {
        el.src = wartosc
          ? "../img_main/icony/arrow.png"
          : "../img_main/icony/arrow_of.png";
      }
    });
  };

  // obsługa błędów połączenia
  roletyStream.onerror = (err) => {
    showAlert();
    console.error("Błąd połączenia ze streamem rolety:", err);
  };
  temperaturaStream.onerror = (err) => {
    showAlert();
    console.error("Błąd połączenia ze streamem temperatury:", err);
  };
  swiatlaStream.onerror = (err) => {
    showAlert();
    console.error("Błąd połączenia ze streamem świateł:", err);
  };

  // po otwarciu polączenia, ukrycie alertu i wyświetlenie komunikatu w konsoli
  roletyStream.onopen = () => {
    hideAlert();
    console.log("Połączono ze streamem rolety");
  };
  temperaturaStream.onopen = () => {
    hideAlert();
    console.log("Połączono ze streamem temperatury");
  };
  swiatlaStream.onopen = () => {
    hideAlert();
    console.log("Połączono ze streamem świateł");
  };
});

/*
  Funkcja do wysyłania żądania włączenia światła.
  Jako parametr przyjmuje nazwe światła, które ma byc włączone, wyłączone.
  Nazwy powinny sie zgadzac z definicjami w serwer_node/variables/floorX !!!
*/
async function wyslijTrue(swiatlo) {
  if (isFetchingLight) return; //jezeli uzytkownik juz wyslal żądanie, nie wykonuj dalej
  try {
    isFetchingLight = true;
    // Najpierw wł.
    await axios.put(`${window.config.apiBaseUrl}/swiatla/${swiatlo}`, {
      wartosc: true,
    });
    await delay(100); //delay dla bezpieczenstwa
    //Potem false
    await axios.put(`${window.config.apiBaseUrl}/swiatla/${swiatlo}`, {
      wartosc: false,
    });
  } catch (err) {
    alertBox.style.display = "block"; // jezeli error, wyswietl alert
    showAlert();
  } finally {
    isFetchingLight = false; // po wszystkim ustawiamy flage na false
  }
}

// Dziala tak samo, jak swiatlo. Rozdzielone dla latwiejszej organizacji i rozbudowy.
async function roletaWlacz(roleta) {
  if (isFetchingBlinds) return;
  isFetchingBlinds = false;
  try {
    await axios.put(`${window.config.apiBaseUrl}/rolety/${roleta}`, {
      wartosc: true,
    });
    await axios.put(`${window.config.apiBaseUrl}/rolety/${roleta}`, {
      wartosc: false,
    });
  } catch (err) {
    showAlert();
    console.error("Błąd wysyłania sygnału do rolet:", err);
  } finally {
    isFetchingBlinds = false;
  }
}
