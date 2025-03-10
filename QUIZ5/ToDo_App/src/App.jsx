import { useState, useEffect } from "react";
import TodoEditForm from "./components/TodoEditForm";
import TodoItem from "./components/TodoItem";
import TodoFilter from "./components/TodoFilter";
import DarkModeToggle from "./components/DarkModeToggle";
import AddTodoForm from "./components/AddTodoForm";
import TodoStats from "./components/TodoStats";
import "./App.css";

const EnhancedTodoApp = () => {
  // State for managing todos
  const [todos, setTodos] = useState(() => {
    const savedTodos = localStorage.getItem("todos");
    return savedTodos
      ? JSON.parse(savedTodos)
      : [
          { id: 1, text: "Learn React", completed: false },
          { id: 2, text: "Build a project", completed: false },
          { id: 3, text: "Deploy application", completed: false },
        ];
  });

  // State for new todo input
  const [newTodo, setNewTodo] = useState("");

  // State for tracking which todo is being edited
  const [editingId, setEditingId] = useState(null);

  // State for filter option
  const [filter, setFilter] = useState("all");

  // State for dark mode
  const [darkMode, setDarkMode] = useState(() => {
    const savedMode = localStorage.getItem("darkMode");
    return savedMode ? JSON.parse(savedMode) : false;
  });

  // Save todos to localStorage when they change
  useEffect(() => {
    localStorage.setItem("todos", JSON.stringify(todos));
  }, [todos]);

  // Save dark mode preference to localStorage
  useEffect(() => {
    localStorage.setItem("darkMode", JSON.stringify(darkMode));
    document.body.className = darkMode ? "dark-mode" : "";
  }, [darkMode]);

  // Function to add a new todo
  const addTodo = () => {
    if (newTodo.trim() === "") return;

    const newItem = {
      id: Date.now(),
      text: newTodo,
      completed: false,
    };

    setTodos([...todos, newItem]);
    setNewTodo("");
  };

  // Function to delete a todo
  const deleteTodo = (id) => {
    setTodos(todos.filter((todo) => todo.id !== id));
  };

  // Function to toggle completion status
  const toggleComplete = (id) => {
    setTodos(
      todos.map((todo) =>
        todo.id === id ? { ...todo, completed: !todo.completed } : todo
      )
    );
  };

  // Function to start editing a todo
  const startEdit = (id) => {
    setEditingId(id);
  };

  // Function to save edited todo
  const saveEdit = (id, newText) => {
    if (newText.trim() === "") return;

    setTodos(
      todos.map((todo) => (todo.id === id ? { ...todo, text: newText } : todo))
    );

    setEditingId(null);
  };

  // Function to cancel editing
  const cancelEdit = () => {
    setEditingId(null);
  };

  // Function to filter todos based on selected filter
  const getFilteredTodos = () => {
    switch (filter) {
      case "completed":
        return todos.filter((todo) => todo.completed);
      case "pending":
        return todos.filter((todo) => !todo.completed);
      default:
        return todos;
    }
  };

  // Toggle dark mode
  const toggleDarkMode = () => {
    setDarkMode(!darkMode);
  };

  const filteredTodos = getFilteredTodos();

  return (
    <div className={`app-container ${darkMode ? "dark" : "light"}`}>
      <div className="todo-app">
        <div className={`app-header ${darkMode ? "dark" : "light"}`}>
          <div className="header-content">
            <h1>Enhanced To-Do List</h1>
            <DarkModeToggle darkMode={darkMode} onToggle={toggleDarkMode} />
          </div>

          <AddTodoForm
            darkMode={darkMode}
            newTodo={newTodo}
            setNewTodo={setNewTodo}
            addTodo={addTodo}
          />

          <TodoFilter
            currentFilter={filter}
            onFilterChange={setFilter}
            darkMode={darkMode}
          />
        </div>

        <ul className={`todo-list ${darkMode ? "dark" : "light"}`}>
          {filteredTodos.length === 0 ? (
            <li className="empty-list">No tasks found</li>
          ) : (
            filteredTodos.map((todo) => (
              <li key={todo.id} className="todo-item-container">
                {editingId === todo.id ? (
                  <TodoEditForm
                    todo={todo}
                    onSave={(newText) => saveEdit(todo.id, newText)}
                    onCancel={cancelEdit}
                    darkMode={darkMode}
                  />
                ) : (
                  <TodoItem
                    todo={todo}
                    onToggleComplete={() => toggleComplete(todo.id)}
                    onEdit={() => startEdit(todo.id)}
                    onDelete={() => deleteTodo(todo.id)}
                    darkMode={darkMode}
                  />
                )}
              </li>
            ))
          )}
        </ul>

        <TodoStats
          todos={todos}
          filteredTodos={filteredTodos}
          darkMode={darkMode}
        />
      </div>
    </div>
  );
};

export default EnhancedTodoApp;
