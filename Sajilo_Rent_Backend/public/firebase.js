import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.3/firebase-app.js";
import { getAuth, RecaptchaVerifier } from "https://www.gstatic.com/firebasejs/9.8.3/firebase-auth.js";

const firebaseConfig = {
    apiKey: "AIzaSyBCk2WPuBPGzVlNDsjZFf2KQCOyzem3yGQ",
    authDomain: "sajilo-rent.firebaseapp.com",
    projectId: "sajilo-rent",
    storageBucket: "sajilo-rent.firebasestorage.app",
    messagingSenderId: "171969234509",
    appId: "1:171969234509:web:0a3dc2931c0abdb6a0fe04"
  };

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

auth.languageCode = "en";

export function initializeRecaptcha() {
  window.recaptchaVerifier = new RecaptchaVerifier(
    "recaptcha-container",
    {
      size: "normal",
      callback: (response) => {
        document.getElementById("submit").removeAttribute("disabled");
      },
      "expired-callback": () => {
        alert("ReCAPTCHA expired! Please try again.");
      },
    },
    auth
  );
  recaptchaVerifier.render();
}
