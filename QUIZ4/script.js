const jsonURL = "https://adibsssss.github.io/PIT4&QUIZ4/courses.json";

fetch("courses.json")
  .then((response) => response.json())
  .then((data) => {
    const coursesList = document.getElementById("courses-list");
    window.coursesData = data.courses;

    data.courses.forEach((course) => {
      const courseItem = document.createElement("div");
      courseItem.classList.add("course-item");
      courseItem.innerHTML = `
              <p><strong>Course Code:</strong> ${course.code}</p>
              <p><strong>Year Level:</strong> ${course.year_level}</p>
              <p><strong>Semester:</strong> ${course.sem}</p>
              <p><strong>Description:</strong> ${course.description}</p>
              <p><strong>Credit Hours:</strong> ${course.credit}</p>
              <hr>
            `;
      coursesList.appendChild(courseItem);
    });
  })
  .catch((error) => console.error("Error loading courses data:", error));

function searchCourses() {
  const searchInput = document
    .getElementById("search-input")
    .value.toLowerCase();
  const coursesList = document.getElementById("courses-list");
  coursesList.innerHTML = "";

  const filteredCourses = window.coursesData.filter((course) =>
    course.description.toLowerCase().includes(searchInput)
  );

  filteredCourses.forEach((course) => {
    const courseItem = document.createElement("div");
    courseItem.classList.add("course-item");
    courseItem.innerHTML = `
            <p><strong>Course Code:</strong> ${course.code}</p>
            <p><strong>Year Level:</strong> ${course.year_level}</p>
            <p><strong>Semester:</strong> ${course.sem}</p>
            <p><strong>Description:</strong> ${course.description}</p>
            <p><strong>Credit Hours:</strong> ${course.credit}</p>
            <hr>
          `;
    coursesList.appendChild(courseItem);
  });
}
