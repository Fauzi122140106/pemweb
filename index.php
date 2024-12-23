<?php
require_once 'connection.php'; // Include the connection class
session_start();

$db = new Connection();
$conn = $db->getConnection();

// Fetch students from the database
$query = "SELECT * FROM tblMahasiswa";
$students = $db->fetchAll($query);

$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Student List</h1>
    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="server.php?action=logout" method="POST" class="mb-4">
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
    
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Add New Student</button>

    <!-- Table to display students -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>NIM</th>
                <th>Email</th>
                <th>Status</th>
                <th>Semester</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $key=>$student): ?>
            <tr>
                <td><?php echo $key + 1 ; ?></td>
                <td><?php echo $student['nama']; ?></td>
                <td><?php echo $student['nim']; ?></td>
                <td><?php echo $student['email']; ?></td>
                <td><?php echo ucfirst($student['status']); ?></td>
                <td><?php echo $student['semester']; ?></td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" 
                        data-id="<?php echo $student['id']; ?>"
                        data-nama="<?php echo $student['nama']; ?>"
                        data-nim="<?php echo $student['nim']; ?>"
                        data-email="<?php echo $student['email']; ?>"
                        data-status="<?php echo $student['status']; ?>"
                        data-semester="<?php echo $student['semester']; ?>">Edit</button>

                    <!-- Delete Button -->
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                        data-id="<?php echo $student['id']; ?>"
                        data-nama="<?php echo $student['nama']; ?>"
                        data-nim="<?php echo $student['nim']; ?>"
                        data-email="<?php echo $student['email']; ?>"
                        data-status="<?php echo $student['status']; ?>"
                        data-semester="<?php echo $student['semester']; ?>">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="container mt-5">
        <h1 class="mb-4">To-Do List</h1>
        <form id="taskForm">
            <div class="input-group mb-3">
                <input type="text" id="taskInput" class="form-control" placeholder="Enter a task" required>
                <button class="btn btn-primary" type="submit">Add Task</button>
            </div>
        </form>

        <ul id="taskList" class="list-group">
            <!-- Task items will be dynamically added here -->
        </ul>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" action="server.php?action=add" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="addNama" class="form-label">Name</label>
                        <input type="text" class="form-control" id="addNama" name="nama" required>
                        <div class="invalid-feedback">Name is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="addNim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="addNim" name="nim" required>
                        <div class="invalid-feedback">NIM is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="addEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="addEmail" name="email" required>
                        <div class="invalid-feedback">Please provide a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <label for="addStatus" class="form-label">Status</label>
                        <select class="form-select" id="addStatus" name="status" required>
                            <option value="">Select status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div class="invalid-feedback">Status is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="addSemester" class="form-label">Semester</label>
                        <input type="number" class="form-control" id="addSemester" name="semester" required>
                        <div class="invalid-feedback">Semester is required.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="server.php?action=update" method="POST" novalidate>
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label for="editNama" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editNama" name="nama" required>
                        <div class="invalid-feedback">Name is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="editNim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="editNim" name="nim" required>
                        <div class="invalid-feedback">NIM is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                        <div class="invalid-feedback">Please provide a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" id="editStatus" name="status" required>
                            <option value="">Select status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div class="invalid-feedback">Status is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="editSemester" class="form-label">Semester</label>
                        <input type="number" class="form-control" id="editSemester" name="semester" required>
                        <div class="invalid-feedback">Semester is required.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="server.php?action=delete" method="POST">
                    <input type="hidden" name="id" id="deleteId">
                    <p>Are you sure you want to delete this student?</p>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script to Populate Modals and Add Validation -->
<script>
    // Edit Modal
    document.getElementById('editModal').addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const nim = button.getAttribute('data-nim');
        const email = button.getAttribute('data-email');
        const status = button.getAttribute('data-status');
        const semester = button.getAttribute('data-semester');
        
        document.getElementById('editId').value = id;
        document.getElementById('editNama').value = nama;
        document.getElementById('editNim').value = nim;
        document.getElementById('editEmail').value = email;
        document.getElementById('editStatus').value = status;
        document.getElementById('editSemester').value = semester;
    });

    // Delete Modal
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        
        document.getElementById('deleteId').value = id;
    });

    // Validation for Add and Edit Forms
    function validateForm(form) {
        const formElements = form.querySelectorAll('input, select');
        form.classList.add('was-validated');
        
        formElements.forEach(input => {
            if (!input.checkValidity()) {
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });
        return form.checkValidity();
    }

    document.getElementById('addForm').addEventListener('submit', function(event) {
        if (!validateForm(this)) {
            event.preventDefault();
        }
    });

    document.getElementById('editForm').addEventListener('submit', function(event) {
        if (!validateForm(this)) {
            event.preventDefault();
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        // Load tasks from Local Storage
        loadTasksFromStorage();

        // Add task event
        document.getElementById('taskForm').addEventListener('submit', (event) => {
            event.preventDefault();
            const taskInput = document.getElementById('taskInput');
            const taskText = taskInput.value.trim();

            if (taskText) {
                addTaskToList(taskText);
                saveTaskToStorage(taskText);
                taskInput.value = '';
            }
        });
    });

    // Add task to the list and display it
    function addTaskToList(taskText) {
        const taskList = document.getElementById('taskList');
        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item', 'task-item');
        listItem.innerHTML = `
            <span>${taskText}</span>
            <button class="btn btn-danger btn-sm" onclick="deleteTask(this)">Delete</button>
        `;
        taskList.appendChild(listItem);
    }

    // Save task to Local Storage and Cookie
    function saveTaskToStorage(taskText) {
        let tasks = JSON.parse(localStorage.getItem('tasks')) || [];
        tasks.push(taskText);
        localStorage.setItem('tasks', JSON.stringify(tasks));

        // Save task count to cookie
        document.cookie = `taskCount=${tasks.length}; path=/; max-age=86400`;
    }

    // Load tasks from Local Storage
    function loadTasksFromStorage() {
        const tasks = JSON.parse(localStorage.getItem('tasks')) || [];
        tasks.forEach(task => addTaskToList(task));
    }

    // Delete task from the list and storage
    function deleteTask(button) {
        const taskItem = button.closest('.task-item');
        const taskText = taskItem.querySelector('span').textContent;

        // Remove from Local Storage
        let tasks = JSON.parse(localStorage.getItem('tasks')) || [];
        tasks = tasks.filter(task => task !== taskText);
        localStorage.setItem('tasks', JSON.stringify(tasks));

        // Remove from the task list
        taskItem.remove();

        // Update task count cookie
        document.cookie = `taskCount=${tasks.length}; path=/; max-age=86400`;
    }
</script>

</body>
</html>
