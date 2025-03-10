import "../styles/DarkModeToggle.css";

const DarkModeToggle = ({ darkMode, onToggle }) => {
  return (
    <button
      onClick={onToggle}
      className={`theme-toggle ${darkMode ? "dark" : "light"}`}
      aria-label={darkMode ? "Switch to light mode" : "Switch to dark mode"}
    >
      {darkMode ? "🔆" : "🌙"}
    </button>
  );
};

export default DarkModeToggle;
