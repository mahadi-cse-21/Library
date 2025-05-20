<!-- layouts/head.blade.php -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Library Management System</title>

<!-- Add Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Add this to your <head> -->
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali&display=swap" rel="stylesheet">


<!-- Global Styles -->
<style>
    /* Mobile sidebar styles */
    .mobile-sidebar {
        position: fixed !important;
        z-index: 50 !important;
        top: 0 !important;
        left: 0 !important;
        height: 100vh !important;
        width: 100% !important;
        max-width: 250px !important;
        background-color: white !important;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1) !important;
        transition: all 0.3s ease !important;
        transform: translateX(0) !important;
    }

    /* Sidebar closed state for mobile */
    @media (max-width: 767px) {
        #sidebar.hidden {
            transform: translateX(-100%) !important;
        }
    }

    /* Overlay for when the sidebar is open */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 40;
        display: none;
        transition: opacity 0.3s ease;
    }

    .sidebar-overlay.active {
        display: block;
    }
</style>