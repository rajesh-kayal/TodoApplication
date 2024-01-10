<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Todo List</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div id="sidebar">
        <span class="close-btn" onclick="toggleSidebar()">&times;</span>

        <h4>
            <i class="bi bi-list-check me-2"></i>
            <span class="text-primary">Online</span>
            <span class="text-danger">Todo</span>
        </h4>
        @if(session()->has('USER'))
        <div class="mt-3">
            Welcome <span class="text-secondary"><b>{{session()->get('USER')}}</b></span>
        </div>
        @endif
        <ul class="nav flex-column">
            <li class="nav-item">
                <button class="nav-link btn btn-md btn-dark mt-3" id="showBtn" onclick="toggleTodoLists()">
                    Show Todo Lists <i class="bi bi-list"></i>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link btn btn-md btn-light mt-3" data-bs-target="#addModal" data-bs-toggle="modal">
                    Add New Todo <i class="bi bi-plus"></i>
                </button>
            </li>
        </ul>
        <div class="mt-3">
            <button class="btn btn-sm btn-danger" onclick="onLogout()">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </button>
        </div>
        <div class="mt-5" style="color: #fff;">
            <h5 class="clickable" onclick="toggleInstructions()" style="cursor: pointer">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                How to use:
            </h5>
            <ul id="instructions" style="list-style-type: disc; display: none; font-size:13px;">
                <li>Create a new todo item by clicking <strong>"Add New Todo"</strong>.</li>
                <li>Manage existing todo items by clicking <strong>"Show Todo Lists"</strong>.</li>
                <li>Edit or delete todo items using the provided buttons.</li>
                <li>Search for specific todo items by title or description using the search bar.</li>
                <li>Sort the todo list by selecting a field from the dropdown and clicking on <strong>"Asc"</strong> or
                    <strong>"Desc"</strong> buttons.</li>
                <li>Logout by clicking the <strong>"Logout"</strong> button.</li>
            </ul>

            <h5 class="clickable" onclick="toggleContact()" style="cursor: pointer">
                <i class="bi bi-envelope-fill text-primary me-2"></i>
                Contact Us:
            </h5>
            <ul id="contact" style="list-style-type: disc; display: none;" class="secondary">
                <li>For any questions or assistance, please email us at <br><strong><a
                            href="mailto:contact@onlinetodo.com">contact@onlinetodo.com</a></strong>.</li>
                <li>You can also reach out to our support team at <br><strong><a
                            href="tell: +19 123-456-7890"> +19 123-456-7890</a></strong>.</li>
            </ul>
        </div>
    </div>
        <span class="add-btn" onclick="showSidebar()"><b><i class="bi bi-caret-right-fill"></i></b></span>
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            if (sidebar.style.display === "none") {
                sidebar.style.display = "block";
            } else {
                sidebar.style.display = "none";
            }
        }
        
    function showSidebar() {
        var sidebar = document.getElementById("sidebar");
        if (sidebar.style.display === "none") {
            sidebar.style.display = "block";
        } else {
            sidebar.style.display = "none";
        }
    }

        function toggleInstructions() {
            var instructions = document.getElementById("instructions");
            if (instructions.style.display === "none") {
                instructions.style.display = "block";
            } else {
                instructions.style.display = "none";
            }
        }

        function toggleContact() {
            var contact = document.getElementById("contact");
            if (contact.style.display === "none") {
                contact.style.display = "block";
            } else {
                contact.style.display = "none";
            }
        }
    </script>




    <div id="content">
        <div class="container">
                <header class="modal-header mt-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-list-check me-2 text-dark" style="font-size: 15px;"></i>
                        <div>
                            <h2 id="text-primary" class="mb-1">Online Todo List</h2>
                            <p class="text-muted">Stay organized and keep track of your tasks</p>
                        </div>
                    </div>
                    <div class="float-end" id="filterOptions" style="display: none;">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" id="search" placeholder="Search Todo Lists..."
                        class="form-control">
                </div>
                <select id="sortField" class="form-select mt-3">
                    <option selected disabled>-- Choose a Field --</option>
                    <option>Title</option>
                    <option>Description</option>
                    <option>Created</option>
                </select>
                <div class="btn-group mt-2">
                    <button id="AscBtn" class="btn btn-secondary btn-sm">
                        <i class="bi bi-sort-alpha-up-alt"></i> Asc
                    </button>
                    <button id="DescBtn" class="btn btn-light btn-sm">
                        <i class="bi bi-sort-alpha-down"></i> Desc
                    </button>
                </div>
            </div>
                </header>

            <hr>
            <div id="result"></div>
            <div id="pagination" class="mt-3"></div>
        </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="bi bi-plus-circle-fill text-primary me-2"></i>
                        Add Todo:
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">
                            <i class="bi bi-pencil-fill text-primary me-2"></i>
                            Title:
                        </label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Write title...">
                    </div>
                    <div class="form-group">
                        <label for="desc">
                            <i class="bi bi-card-text-fill text-primary me-2"></i>
                            Description:
                        </label>
                        <textarea name="desc" id="desc" cols="30" rows="10" class="form-control" placeholder="Write description..."></textarea>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-sm btn-success" id="btnAdd">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="bi bi-pencil-circle-fill text-primary me-2"></i>
                        Edit Todo:
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editTitle">
                            <i class="bi bi-pencil-fill text-primary me-2"></i>
                            Title:
                        </label>
                        <input type="text" name="editTitle" id="editTitle" class="form-control" placeholder="Write title...">
                    </div>
                    <div class="form-group">
                        <label for="editDesc">
                            <i class="bi bi-card-text-fill text-primary me-2"></i>
                            Description:
                        </label>
                        <textarea name="editDesc" id="editDesc" cols="30" rows="10" class="form-control" placeholder="Write description..."></textarea>
                    </div>
                    <input type="hidden" name="hid" id="hid">
                    <div class="form-group">
                        <button type="button" class="btn btn-sm btn-success" id="btnEdit">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            var isLoggedIn = "{{ session()->has('USER') }}";
            if (!isLoggedIn) {
                alert("You need to log in to access this page !");
                window.location.href = "{{ url('/users') }}";
            }
        });
    
        var currentPage = 1;
        var sortField = null;
        var sortOrder = "ASC";
        function toggleTodoLists() {
            var filterOptions = $("#filterOptions");
            if (filterOptions.css("display") === "none") {
                filterOptions.css("display", "block");
                showLoader();
                setTimeout(loadTodo, 3000);
            } else {
                filterOptions.css("display", "none");
                $("#result").empty();
                $("#pagination").empty();
            }
        }

        function showLoader() {
        $("#result").html('<div class="loader"><img src="{{ asset('image/any.loader.gif') }}" alt="Loading..." style="width: 70px; height: 70px;"><p>Please wait...</p></div>');
        }
        function loadTodo() {
            $.ajax({
                url: "{{ url('/todos') }}",
                method: "GET",
                data: {
                    page: currentPage,
                    sortField: sortField,
                    sortOrder: sortOrder
                },
                success: function(data) {
                    var todoData = data.data;
                    var tableContent = `<table class="table table-hover table-bordered table-dark">
                <tr>
                    <th>Actions</th>
                    <th>S/N.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Created</th>
                </tr>`;
                    let slNo = (data.current_page - 1) * data.per_page + 1;
                    for (let todoObj of todoData) {
                        tableContent += `
                    <tr>
                        <td>
                            <a href="#" onclick="deleteTodo(${todoObj.todo_id})" class="btn btn-sm btn-danger">Delete</a> |
                            <a href="#" data-bs-target="#editModal" onclick="editTodo(${todoObj.todo_id})" data-bs-toggle="modal" class="btn btn-sm btn-success">Edit</a>
                        </td>
                        <td class="w-10">${slNo}</td>
                        <td>${todoObj.title}</td>
                        <td>${todoObj.description}</td>
                        <td>${todoObj.created}</td>
                    </tr>`;
                        slNo++;
                    }
                    tableContent += '</table>';
                    $("#result").html(tableContent);

                    var paginationContent = '';
                    for (let i = 1; i <= data.last_page; i++) {
                        if (i === data.current_page) {
                            paginationContent += `<a href="#" class="btn btn-sm btn-dark active">${i}</a> `;
                        } else {
                            paginationContent += `<a href="#" onclick="loadPage(${i})" class="btn btn-sm btn-dark">${i}</a> `;
                        }
                    }
                    $("#pagination").html(paginationContent);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function loadPage(page) {
            currentPage = page;
            loadTodo();
            var sortField = $("#sortField").val();
            var sortOrder = $("#AscBtn").hasClass("active") ? "ASC" : "DESC";

            $.ajax({
                url: "{{ url('/todos') }}",
                method: "GET",
                data: {
                    page: page,
                    sortField: sortField,
                    sortOrder: sortOrder
                },
                success: function(data) {
                    var todoData = data.data;
                    var tableContent = `
                <table class="table table-hover table-bordered table-dark">
                    <tr>
                        <th>Actions</th>
                        <th>S/N.</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Created</th>
                    </tr>`;
                    let slNo = (data.current_page - 1) * data.per_page + 1;
                    for (let todoObj of todoData) {
                        tableContent += `
                    <tr>
                        <td>
                            <a href="#" onclick="deleteTodo(${todoObj.todo_id})" class="btn btn-sm btn-danger">Delete</a> |
                            <a href="#" data-bs-target="#editModal" onclick="editTodo(${todoObj.todo_id})" data-bs-toggle="modal" class="btn btn-sm btn-success">Edit</a>
                        </td>
                        <td class="w-10">${slNo}</td>
                        <td>${todoObj.title}</td>
                        <td>${todoObj.description}</td>
                        <td>${todoObj.created}</td>
                    </tr>`;
                        slNo++;
                    }
                    tableContent += '</table>';
                    $("#result").html(tableContent);

                    var paginationContent = '';
                    for (let i = 1; i <= data.last_page; i++) {
                        if (i === data.current_page) {
                            paginationContent += `<a href="#" class="btn btn-sm btn-light active">${i}</a> `;
                        } else {
                            paginationContent += `<a href="#" onclick="loadPage(${i})" class="btn btn-sm btn-light">${i}</a> `;
                        }
                    }
                    $("#pagination").html(paginationContent);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $("#btnAdd").click(function() {
            console.log("btnAdd clicked");
            $.ajax({
                url: "{{url('/todo/add')}}",
                method: "POST",
                data: {
                    'title': $('#title').val(),
                    'desc': $('#desc').val()
                },
                success: function(data) {
                    console.log(data);
                    alert(data.message);
                    $('#addModal').modal('hide');
                    loadTodo();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $("#search").keyup(function() {
            let search = $(this).val();
            if (search.length >= 3) {
                $.ajax({
                    url: "{{url('/todo/search')}}",
                    method: "POST",
                    data: {
                        'data': search
                    },
                    success: function(data) {
                        let todoData = data;
                        var tableContent = `<table class="table table-hover table-bordered table-dark">
                            <tr>
                                <th>Actions #</th>
                                <th>S/N.</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Created</th>
                            </tr>`;
                        let slNo = 1;
                        for (let todoObj of todoData) {
                            tableContent += `
                                <tr>
                                    <td>
                                        <a href="#" onclick="deleteTodo(${todoObj.todo_id})" class="btn btn-sm btn-danger">Delete</a>
                                        <a href="#" data-bs-target="#editModal" onclick="editTodo(${todoObj.todo_id})" data-bs-toggle="modal" class="btn btn-sm btn-success">Edit</a>
                                    </td>
                                    <td class="w-10">${slNo}</td>
                                    <td>${todoObj.title}</td>
                                    <td>${todoObj.description}</td>
                                    <td>${todoObj.created}</td>
                                </tr>`;
                            slNo++;
                        }
                        tableContent += `</table>`;
                        $("#result").html(tableContent);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });

        $("#sortField").change(function() {
            sortField = $(this).val();
            loadTodo();
        });


        $("#AscBtn").click(function() {
            var sortField = $("#sortField").val();
            if (sortField === null) {
                alert("Please select a field!");
                return;
                var sortOrder = "ASC"; 
                loadPage(currentPage);
            }else{
            $.ajax({
                url: "{{url('/todo/sort')}}",
                method: "POST",
                data: { 's1': sortField, 's2': 'ASC','page': currentPage },
                success: function(data,status) {
                    console.log(data);
                    let todoData = data;
                    var tableContent = `<table class="table table-hover table-bordered table-dark">
                                <tr>
                                    <th>Actions</th>
                                    <th>S/N.</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                </tr>`;
                    let slNo = 1;
                    for (let todoObj of todoData) {
                        tableContent += `
                                    <tr>
                                        <td>
                                            <a href="#" onclick="deleteTodo(${todoObj.todo_id})" class="btn btn-sm btn-danger">Delete</a>
                                            <a href="#" data-bs-target="#editModal" onclick="editTodo(${todoObj.todo_id})" data-bs-toggle="modal" class="btn btn-sm btn-success">Edit</a>
                                        </td>
                                        <td class="w-10">${slNo}</td>
                                        <td>${todoObj.title}</td>
                                        <td>${todoObj.description}</td>
                                        <td>${todoObj.created}</td>
                                    </tr>`;
                        slNo++;
                    }
                    tableContent += '</table>';
                    $("#result").html(tableContent);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        });

        $("#DescBtn").click(function() {
            var sortField = $("#sortField").val();
            if (sortField === null) {
                alert("Please select a field!");
                return;
                var sortOrder = "DESC"; 
                loadPage(currentPage);
            }else{
            $.ajax({
                url: "{{url('/todo/sort')}}",
                method: "POST",
                data: { 's1': sortField, 's2': 'DESC','page': currentPage },
                success: function(data,status) {
                    console.log(data);
                    let todoData = data;
                    var tableContent = `<table class="table table-hover table-bordered table-dark">
                                <tr>
                                    <th>Actions #</th>
                                    <th>S/N.</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                </tr>`;
                    let slNo = 1;
                    for (let todoObj of todoData) {
                        tableContent += `
                                    <tr>
                                        <td>
                                            <a href="#" onclick="deleteTodo(${todoObj.todo_id})" class="btn btn-sm btn-danger">Delete</a>
                                            <a href="#" data-bs-target="#editModal" onclick="editTodo(${todoObj.todo_id})" data-bs-toggle="modal" class="btn btn-sm btn-success">Edit</a>
                                        </td>
                                        <td class="w-10">${slNo}</td>
                                        <td>${todoObj.title}</td>
                                        <td>${todoObj.description}</td>
                                        <td>${todoObj.created}</td>
                                    </tr>`;
                        slNo++;
                    }
                    tableContent += '</table>';
                    $("#result").html(tableContent);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        });

        //Current Date
        function CurrentTime() {
            let myDate = new Date();

            let day = myDate.getDate();
            let month = myDate.getMonth() + 1;
            let year = myDate.getFullYear();

            let hr = myDate.getHours();
            let min = myDate.getMinutes();
            let sec = myDate.getSeconds();

            return year + "-" + month + "-" + day + " " + hr + ":" + min + ":" + sec;
        }

        $("#btnEdit").click(function() {
            var dataUpdate = {
                'title': $("#editTitle").val(),
                'description': $("#editDesc").val(),
                'created': CurrentTime()
            };
            var todo_id = $('#hid').val();

            $.ajax({
                url: "{{url('/todo')}}" + "/" + todo_id,
                method: "PUT",
                data: dataUpdate,
                success: function(data) {
                    console.log(data);
                    alert(data.message);
                    loadTodo();
                    $("#editModal").modal('hide');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        function editTodo(todo_id) {
            console.log(todo_id);
            $.ajax({
                url: "{{url('/todo/edit')}}" + "/" + todo_id,
                method: "GET",
                success: function(data) {
                    console.log(data);
                    $("#editTitle").val(data.title);
                    $("#editDesc").val(data.description);
                    $("#hid").val(data.todo_id);
                    $("#editModal").modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function deleteTodo(todo_id) {
            console.log(todo_id);
            var con = confirm("Do you want to Delete This Record ? ");
            if (con) {
                $.ajax({
                    url: "{{url('/todo/delete')}}" + "/" + todo_id,
                    type: "DELETE",
                    success: function(data) {
                        alert(data.message);
                        loadTodo();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        }

        function onLogout() {
            $.ajax({
                url: "{{url('/users/logout')}}",
                method: "GET",
                success: function(data) {
                    if (data.message == 'success') {
                        alert('You have successfully logged out!');
                        window.location.href = "{{url('/users')}}";
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
</body>
</html>