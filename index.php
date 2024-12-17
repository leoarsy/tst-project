<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<?php
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $validUsername = 'admin';
    $validPassword = '123';

    if ($username === $validUsername && $password === $validPassword) {
        header('Location: /project_abin/lms.html');
        exit();
    } else {
        $errorMessage = 'Username atau password salah!';
    }
}
?>

<div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-700 text-center">Login</h2>
    <form method="POST" action="" class="mt-6">
        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input 
                type="text" 
                name="username" 
                id="username" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Masukkan username" 
                required
            >
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Masukkan password" 
                required
            >
        </div>
        <?php if ($errorMessage): ?>
            <div class="mb-4 text-red-600 text-sm font-medium">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
        <div>
            <button 
                type="submit" 
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                Login
            </button>
        </div>
    </form>
</div>

</body>
</html>
