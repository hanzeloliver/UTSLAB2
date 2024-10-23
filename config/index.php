<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Todo List</a>
            <div class="navbar-nav ms-auto">
                <span class="nav-item nav-link">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">My Todo List</h4>
                    </div>
                    <div class="card-body">
                        <form id="addTodoForm" class="mb-4">
                            <div class="input-group">
                                <input type="text" id="todoInput" class="form-control" placeholder="Enter new task" required>
                                <button type="submit" class="btn btn-primary">Add Task</button>
                            </div>
                        </form>

                        <div class="btn-group mb-3">
                            <button class="btn btn-outline-secondary" data-filter="all">All</button>
                            <button class="btn btn-outline-secondary" data-filter="active">Active</button>
                            <button class="btn btn-outline-secondary" data-filter="completed">Completed</button>
                        </div>

                        <ul id="todoList" class="list-group">
                            <!-- Tasks will be inserted here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadTodos();
            
            // Add Todo Form
            document.getElementById('addTodoForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const input = document.getElementById('todoInput');
                const task = input.value.trim();
                
                if (task) {
                    addTodo(task);
                    input.value = '';
                }
            });

            // Filter Buttons
            document.querySelectorAll('[data-filter]').forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.dataset.filter;
                    filterTodos(filter);
                });
            });
        });

        function loadTodos() {
            fetch('api/get_todos.php')
                .then(response => response.json())
                .then(todos => {
                    const todoList = document.getElementById('todoList');
                    todoList.innerHTML = '';
                    
                    todos.forEach(todo => {
                        const li = createTodoElement(todo);
                        todoList.appendChild(li);
                    });
                });
        }

        function createTodoElement(todo) {
            const li = document.createElement('li');
            li.className = `list-group-item d-flex justify-content-between align-items-center ${todo.status ? 'bg-light' : ''}`;
            li.dataset.id = todo.id;
            li.dataset.status = todo.status;

            const taskSpan = document.createElement('span');
            taskSpan.className = todo.status ? 'text-decoration-line-through' : '';
            taskSpan.textContent = todo.task;
            li.appendChild(taskSpan);

            const btnGroup = document.createElement('div');
            btnGroup.className = 'btn-group';

            const toggleBtn = document.createElement('button');
            toggleBtn.className = `btn btn-sm ${todo.status ? 'btn-success' : 'btn-outline-success'}`;
            toggleBtn.innerHTML = '<i class="fas fa-check"></i>';
            toggleBtn.onclick = () => toggleTodo(todo.id);

            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn btn-sm btn-outline-danger';
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
            deleteBtn.onclick = () => deleteTodo(todo.id);

            btnGroup.appendChild(toggleBtn);
            btnGroup.appendChild(deleteBtn);
            li.appendChild(btnGroup);

            return li;
        }

        function addTodo(task) {
            fetch('api/add_todo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `task=${encodeURIComponent(task)}`
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    loadTodos();
                }
            });
        }

        function toggleTodo(id) {
            fetch('api/toggle_todo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}`
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    loadTodos();
                }
            });
        }

        function deleteTodo(id) {
            if (confirm('Are you sure you want to delete this task?')) {
                fetch('api/delete_todo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        loadTodos();
                    }
                });
            }
        }

        function filterTodos(filter) {
            const todos = document.querySelectorAll('#todoList li');
            todos.forEach(todo => {
                const status = todo.dataset.status === '1';
                switch(filter) {
                    case 'active':
                        todo.style.display = !status ? '' : 'none';
                        break;
                    case 'completed':
                        todo.style.display = status ? '' : 'none';
                        break;
                    default:
                        todo.style.display = '';
                }
            });
        }
    </script>
</body>
</html>
