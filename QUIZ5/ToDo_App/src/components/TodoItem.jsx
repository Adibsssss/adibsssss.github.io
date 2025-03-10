import "../styles/TodoItem.css";

const TodoItem = ({ todo, onToggleComplete, onEdit, onDelete, darkMode }) => {
  return (
    <div className={`todo-item ${darkMode ? "dark" : "light"}`}>
      <div className="todo-content">
        <input
          type="checkbox"
          checked={todo.completed}
          onChange={onToggleComplete}
          className="todo-checkbox"
        />
        <span className={`todo-text ${todo.completed ? "completed" : ""}`}>
          {todo.text}
        </span>
      </div>
      <div className="todo-actions">
        <button onClick={onEdit} className="edit-button" aria-label="Edit">
          ✏️
        </button>
        <button
          onClick={onDelete}
          className="delete-button"
          aria-label="Delete"
        >
          🗑️
        </button>
      </div>
    </div>
  );
};

export default TodoItem;
