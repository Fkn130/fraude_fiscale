const themeToggle = document.getElementById("themeToggle");

themeToggle.addEventListener("click", () => {
    const isDark =
        document.documentElement.getAttribute("data-theme") === "dark";

    const newTheme = isDark ? "light" : "dark";

    document.documentElement.setAttribute("data-theme", newTheme);

    themeToggle.textContent =
        newTheme === "dark" ? "☀️ Mode jour" : "🌙 Mode nuit";
});