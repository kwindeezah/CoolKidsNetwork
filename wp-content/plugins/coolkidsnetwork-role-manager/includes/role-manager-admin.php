<?php

// Adds the admin menu page
add_action('admin_menu', 'coolkidsnetwork_add_admin_menu');

function coolkidsnetwork_add_admin_menu() {
    add_menu_page(
        'Role Manager',
        'Role Manager',
        'manage_options',
        'coolkidsnetwork-role-manager',
        'coolkidsnetwork_role_manager_page'
    );
}

// Role maintainer's page content
function coolkidsnetwork_role_manager_page() {
    ?>
    <div class="wrap">
        <h1>Change User Role</h1>
        <form id="change-role-form">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
            
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
            
            <label for="role">New Role:</label>
            <select id="role" name="role" required>
                <option value="Cool Kid">Cool Kid</option>
                <option value="Cooler Kid">Cooler Kid</option>
                <option value="Coolest Kid">Coolest Kid</option>
            </select>
            
            <input type="submit" value="Change Role">
        </form>
        <div id="response"></div>
    </div>
    <script>
        document.getElementById('change-role-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            fetch('<?php echo esc_url(rest_url('coolkidsnetwork/v1/change-role')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('response').innerText = data.message || 'Role updated successfully!';
            })
            .catch(error => {
                document.getElementById('response').innerText = 'Error: ' + error.message;
            });
        });
    </script>
    <?php
}