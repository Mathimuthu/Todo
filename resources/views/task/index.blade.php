<x-app-layout>
    <div class="container-fluid mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">📜 Todo Tasks</h2>
            <a href="{{ route('task.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-blue-700 transition">
                ➕ Create New Task
            </a>
        </div>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden overflow-x-auto">
            <table id="task-table" class="display w-full border-collapse">
                <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3 text-left">S.No</th>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Description</th>
                        <th class="px-4 py-3 text-left">Created At</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">

                </tbody>
            </table>
        </div>
    </div>
    <script>
        function getTasks() {
            axios.get('/api/task', {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('auth_token') 
                }
            })
            .then(response => {
                const tasks = response.data.data;
                let taskListHtml = '';
                tasks.forEach((task, index) => {
                    const statusIcon = task.status === 'Active' ? '✅ Active' : '❌ Inactive';
                    const completionStatus = task.is_complete ? '✅ Completed' : '❌ Incomplete';
                    let actionButtons = '';

                    if (task.status === 'Active') {
                        actionButtons = `
                            <a href="{{ url('task/${task.id}/edit') }}" class="px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded shadow-md hover:bg-yellow-600 transition">✏️ Edit</a>
                            <button onclick="deactivateTask(${task.id})" class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded shadow-md hover:bg-red-600 transition">🛑 Deactivate</button>
                        `;
                    } else {
                        actionButtons = `<span class="text-gray-500">Inactive</span>`;
                    }

                    taskListHtml += `
                        <tr class="hover:bg-gray-100 transition">
                            <td class="px-4 py-3">${index + 1}</td>
                            <td class="px-4 py-3">${task.title}</td>
                            <td class="px-4 py-3">${task.description}</td>
                            <td class="px-4 py-3">${task.created_at}</td>
                            <td class="px-4 py-3 text-center">${completionStatus}</td>
                            <td class="px-4 py-3 text-center">
                                ${actionButtons}
                            </td>
                        </tr>
                    `;
                });

                document.querySelector('#task-table tbody').innerHTML = taskListHtml;

                if ($.fn.dataTable.isDataTable('#task-table')) {
                    $('#task-table').DataTable().destroy();
                }
                $('#task-table').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    pageLength: 10,
                    lengthChange: false
                });
            })
            .catch(error => console.log(error));
        }

        function deactivateTask(taskId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to deactivate this task!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, deactivate it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/task/${taskId}`)
                        .then(response => {
                            Swal.fire({
                                title: 'Deactivated!',
                                text: response.data.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong while deactivating the task.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                }
            });
        }
        getTasks();
    </script>
</x-app-layout>
