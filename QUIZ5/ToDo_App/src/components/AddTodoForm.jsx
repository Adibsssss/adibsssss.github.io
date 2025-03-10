import "../styles/AddTodoForm.css";

const AddTodoForm = ({ darkMode, newTodo, setNewTodo, addTodo }) => {
  return (
    <div className={`add-form ${darkMode ? "dark" : "light"}`}>
      <input
        type="text"
        value={newTodo}
        onChange={(e) => setNewTodo(e.target.value)}
        onKeyPress={(e) => e.key === "Enter" && addTodo()}
        placeholder="Add a new task..."
        className={`add-input ${darkMode ? "dark" : "light"}`}
      />
      <button onClick={addTodo} className="add-button">
        Add
      </button>
    </div>
  );
};

export default AddTodoForm;
