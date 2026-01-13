<?php
// This view helps diagnose sidebar issues

// Count sidebar elements in rendered HTML
// This script will be embedded in admin views for debugging
?>

<div style="position: fixed; bottom: 20px; right: 20px; background: #f0f0f0; padding: 15px; border-radius: 8px; font-size: 12px; max-width: 300px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
    <strong>🔍 Sidebar Diagnostic</strong>
    <div id="sidebar-info" style="margin-top: 10px; font-family: monospace; color: #333;">
        <p>Checking sidebar elements...</p>
    </div>
    <button onclick="closeDiagnostic()" style="margin-top: 10px; padding: 5px 10px; background: #999; color: white; border: none; border-radius: 4px; cursor: pointer;">Close</button>
</div>

<script>
(function() {
    // Count sidebar elements
    const sidebars = document.querySelectorAll('aside.sidebar');
    const mainContainers = document.querySelectorAll('.main-container');
    const navbars = document.querySelectorAll('.navbar');
    const mainContents = document.querySelectorAll('.main-content');
    
    const info = document.getElementById('sidebar-info');
    
    let html = `
        <p><strong>Elements Found:</strong></p>
        <p>🔹 Navbars: <span style="color: ${navbars.length > 1 ? 'red' : 'green'}">${navbars.length}</span></p>
        <p>🔹 Main Containers: <span style="color: ${mainContainers.length > 1 ? 'red' : 'green'}">${mainContainers.length}</span></p>
        <p>🔹 Sidebars: <span style="color: ${sidebars.length > 1 ? 'red' : 'green'}">${sidebars.length}</span></p>
        <p>🔹 Main Contents: <span style="color: ${mainContents.length > 1 ? 'red' : 'green'}">${mainContents.length}</span></p>
    `;
    
    if (sidebars.length > 1) {
        html += '<p style="color: red; margin-top: 10px;"><strong>⚠️ Multiple sidebars detected!</strong></p>';
        sidebars.forEach((sidebar, idx) => {
            html += `<p>Sidebar ${idx + 1}: <button onclick="highlightElement(event)">Highlight</button></p>`;
        });
    } else if (sidebars.length === 1) {
        html += '<p style="color: green;"><strong>✅ Single sidebar detected</strong></p>';
    } else {
        html += '<p style="color: orange;"><strong>⚠️ No sidebars found</strong></p>';
    }
    
    info.innerHTML = html;
    
    // Make highlighting function global
    window.highlightElement = function(e) {
        e.preventDefault();
        sidebars.forEach(s => s.style.border = '');
        const sidebar = e.target.closest('button').parentElement.querySelector('aside.sidebar') || sidebars[0];
        if (sidebar) {
            sidebar.style.border = '3px solid red';
            sidebar.scrollIntoView({ behavior: 'smooth' });
        }
    };
    
    window.closeDiagnostic = function() {
        document.querySelector('[id="sidebar-info"]').parentElement.remove();
    };
})();
</script>

<style>
@media (max-width: 768px) {
    div[style*="position: fixed"][style*="bottom: 20px"] {
        bottom: 10px !important;
        right: 10px !important;
        max-width: 250px !important;
        font-size: 11px !important;
    }
}
</style>
