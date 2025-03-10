import "../styles/TodoFilter.css";

const TodoFilter = ({ currentFilter, onFilterChange, darkMode }) => {
  return (
    <div className={`filter-container ${darkMode ? "dark" : "light"}`}>
      <button
        onClick={() => onFilterChange("all")}
        className={`filter-button ${currentFilter === "all" ? "active" : ""} ${
          darkMode ? "dark" : "light"
        }`}
      >
        All
      </button>
      <button
        onClick={() => onFilterChange("completed")}
        className={`filter-button ${
          currentFilter === "completed" ? "active" : ""
        } ${darkMode ? "dark" : "light"}`}
      >
        Completed
      </button>
      <button
        onClick={() => onFilterChange("pending")}
        className={`filter-button ${
          currentFilter === "pending" ? "active" : ""
        } ${darkMode ? "dark" : "light"}`}
      >
        Pending
      </button>
    </div>
  );
};

export default TodoFilter;
