import "../styles/TodoStats.css";

const TodoStats = ({ todos, filteredTodos, darkMode }) => {
  return (
    <div className={`stats-container ${darkMode ? "dark" : "light"}`}>
      <p>
        {filteredTodos.length} {filteredTodos.length === 1 ? "task" : "tasks"} •{" "}
        {todos.filter((todo) => todo.completed).length} completed
      </p>
    </div>
  );
};

export default TodoStats;
