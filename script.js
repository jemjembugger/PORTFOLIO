const nav = document.getElementById("nav");
const menu = document.getElementById("menu");
const links = Array.from(document.querySelectorAll("nav a"));
const heroPanel = document.querySelector(".hero__panel");

menu?.addEventListener("click", () => {
  nav.classList.toggle("open");
});

links.forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault();
    const target = document.querySelector(link.getAttribute("href"));
    if (target) {
      target.scrollIntoView({ behavior: "smooth" });
    }
    nav.classList.remove("open");
  });
});

if (heroPanel) {
  heroPanel.addEventListener("pointermove", (e) => {
    const rect = heroPanel.getBoundingClientRect();
    const x = ((e.clientX - rect.left) / rect.width - 0.5) * 10;
    const y = ((e.clientY - rect.top) / rect.height - 0.5) * 10;
    heroPanel.style.transform = `perspective(900px) rotateX(${y * -1}deg) rotateY(${x}deg)`;
  });

  heroPanel.addEventListener("pointerleave", () => {
    heroPanel.style.transform = "none";
  });
}

const form = document.getElementById("contactForm");
form?.addEventListener("submit", async (e) => {
  e.preventDefault();
  const formData = new FormData(form);
  const notice = document.createElement("div");
  notice.className = "toast";

  try {
    const response = await fetch(form.action, { method: "POST", body: formData });
    const result = await response.json();

    if (result?.success) {
      notice.textContent = "Signal sent. I will respond soon.";
      form.reset();
    } else {
      notice.textContent = result?.message || "Something went wrong. Try again.";
    }
  } catch (err) {
    notice.textContent = "Network error. Please retry.";
  }

  document.body.appendChild(notice);
  setTimeout(() => notice.remove(), 2600);
});
