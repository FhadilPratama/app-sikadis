var to_build = "/";

// === LOAD DEPENDENCIES (URUT & TIDAK ASYNC) ===
loadJS("/assets/js/perfect-scrollbar.js");
loadJS("/assets/js/navbar-collapse.js");
loadJS("/assets/js/sidenav-burger.js");
loadJS("/assets/js/navbar-sticky.js");
loadJS("/assets/js/fixed-plugin.js");

function loadJS(src) {
  const script = document.createElement("script");
  script.src = src;
  document.body.appendChild(script);
}
