<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Create New Task</h2>
            <a href="{{ route('task.index') }}" 
               class="px-4 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-gray-700 transition">
                ← Back to Task
            </a>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-2xl mx-auto">
            <form id="create-task-form">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                    <input type="text" id="title" name="title" class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" placeholder="Enter title">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                    <textarea id="description" name="description" rows="4" class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" placeholder="Enter description"></textarea>
                </div>
                <div class="mb-4">
                    <label for="is_complete" class="block text-sm font-medium text-gray-700">Is Complete</label>
                    <input type="radio" id="is_complete" name="is_complete" value="1" checked> Yes
                    <input type="radio" id="is_complete" name="is_complete" value="0"> No
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold shadow-md hover:bg-blue-700 transition">
                        🚀 Create Task
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
       document.getElementById('create-task-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            axios.post('/api/task', {
                title: formData.get('title'),
                description: formData.get('description'),
                is_complete: formData.get('is_complete'),
                user_id: "{{ auth()->id() }}"
            })
            .then(response => {
                Swal.fire({
                    title: 'Success!',
                    text: response.data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '/task'; 
                });
            })
            .catch(error => {
                console.log(error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong while creating the task.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</x-app-layout>
