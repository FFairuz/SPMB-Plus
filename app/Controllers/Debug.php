<?php
namespace App\Controllers;
use App\Models\Role;
use App\Models\User;

class Debug extends BaseController
{
    public function users()
    {
        $userModel = new User();
        $users = $userModel->findAll();
        
        echo "<h2>All Users in Database:</h2>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Email</th><th>Role</th><th>Nama</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "<td><strong>{$user['role']}</strong></td>";
            echo "<td>{$user['nama']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h2>Sales User Status:</h2>";
        $salesUser = $userModel->getByEmail('sales@ppdb.local');
        if ($salesUser) {
            echo "✓ Sales user found!<br>";
            echo "Role: <strong>" . $salesUser['role'] . "</strong><br>";
            echo "Password hash exists: " . (!empty($salesUser['password']) ? 'Yes' : 'No') . "<br>";
            
            // Test password
            $testPassword = password_verify('password123', $salesUser['password']);
            echo "Password verification: " . ($testPassword ? '<span style="color:green;"><strong>PASSED</strong></span>' : '<span style="color:red;"><strong>FAILED</strong></span>') . "<br>";
        } else {
            echo "✗ Sales user NOT found!<br>";
        }
        
        echo "<hr><p><a href='/debug/roles'>View Roles</a> | <a href='/auth/login'>Login</a></p>";
    }

    public function roles()
    {
        $roleModel = new Role();
        $roles = $roleModel->findAll();
        
        echo "<h2>All Roles in Database:</h2>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Name</th><th>Display Name</th><th>Description</th></tr>";
        foreach ($roles as $role) {
            echo "<tr>";
            echo "<td>{$role['id']}</td>";
            echo "<td><strong>{$role['name']}</strong></td>";
            echo "<td>{$role['display_name']}</td>";
            echo "<td>{$role['description']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h2>Sales Role Status:</h2>";
        $salesRole = $roleModel->getByName('sales');
        if ($salesRole) {
            echo "✓ Sales role exists in database!<br>";
            echo "Display Name: <strong>" . $salesRole['display_name'] . "</strong><br>";
            echo "Description: " . $salesRole['description'] . "<br>";
        } else {
            echo "✗ Sales role NOT found in database!<br>";
        }
        
        echo "<hr>";
        echo "<p><a href='/debug/users'>View Users</a> | <a href='/auth/login'>Login</a></p>";
    }
}
?>
