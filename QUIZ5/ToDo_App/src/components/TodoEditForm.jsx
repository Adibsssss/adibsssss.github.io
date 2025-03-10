import { useState } from "react";
import "../styles/TodoEditForm.css";

const TodoEditForm = ({ todo, onSave, onCancel, darkMode }) => {
  const [editText, setEditText] = useState(todo.text);

  return (
    <div className={`edit-form ${darkMode ? "dark" : "light"}`}>
      <input
        type="text"
        value={editText}
        onChange={(e) => setEditText(e.target.value)}
        onKeyPress={(e) => e.key === "Enter" && onSave(editText)}
        className={`edit-input ${darkMode ? "dark" : "light"}`}
        autoFocus
      />
      <button onClick={() => onSave(editText)} className="save-button">
        Save
      </button>
      <button onClick={onCancel} className="cancel-button">
        Cancel
      </button>
    </div>
  );
};

export default TodoEditForm;
