jQuery(document).ready(function($) {
    $('.wp-sidebar-menu').on('click', '.parent-item > a', function(event) {
        var $clickedItem = $(this).parent();
        var $submenu = $clickedItem.children('.submenu');

        // Check if the clicked item has a submenu
        if ($submenu.length > 0) {
            event.preventDefault(); // Prevent default link behavior only if submenu exists

            // If the submenu is already visible, hide it and remove 'open' class
            if ($submenu.is(':visible')) {
                $submenu.slideUp();
                $clickedItem.removeClass('open');
            } else {
                // Hide all submenus at the same level as the clicked item
                $clickedItem.siblings('.parent-item').find('> .submenu').slideUp();
                $clickedItem.siblings('.parent-item').removeClass('open');

                // Show the clicked submenu and add 'open' class
                $submenu.slideDown();
                $clickedItem.addClass('open');
            }
        } else {
            // If there is no submenu, allow the link to work as normal
            window.location.href = $(this).attr('href');
        }
    });

    // Handle clicks outside the menu to close open submenus
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.wp-sidebar-menu').length) {
            $('.wp-sidebar-menu .submenu').slideUp();
            $('.wp-sidebar-menu .parent-item').removeClass('open');
        }
    });
});

