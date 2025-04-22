document.addEventListener('DOMContentLoaded', () => {
    // Sidebar toggle
    const sideBarToggler = document.querySelector(".sidebar-toggler");
    const sideBar = document.querySelector(".sidebar");
    const navbar = document.querySelector(".navbar");

    if (sideBarToggler && sideBar) {
        sideBarToggler.addEventListener("click", () => {
            const isCollapsed = sideBar.classList.toggle("collapsed");
            navbar.style.marginLeft = isCollapsed ? '101px' : '286px';
            sideBarToggler.setAttribute(
                "aria-label",
                isCollapsed ? "Expand sidebar" : "Collapse sidebar"
            );
        });
    }

    // Mobile menu
    const mobileMenuBtn = document.querySelector(".mobile-menu-button");
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener("click", () => {
            sideBar.classList.toggle("expanded");
        });
    }

    // Navbar profile dropdown
    const navProfileTrigger = document.querySelector(".profile-trigger");
    const navProfileMenu = document.querySelector(".profile-menu");
    
    if (navProfileTrigger && navProfileMenu) {
        navProfileTrigger.addEventListener("click", (e) => {
            e.stopPropagation();
            navProfileMenu.classList.toggle("active");
            
            // Rotate arrow icon
            const arrow = navProfileTrigger.querySelector(".material-symbols-rounded");
            arrow.style.transform = navProfileMenu.classList.contains("active") ? "rotate(180deg)" : "";
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (!navProfileMenu.contains(e.target)) {
                navProfileMenu.classList.remove("active");
                const arrow = navProfileTrigger.querySelector(".material-symbols-rounded");
                arrow.style.transform = "";
            }
        });
    }

    // Mobile profile dropdown
    const mobileProfileBtn = document.querySelector(".mobile-profile .profile-link");
    const mobileProfile = document.querySelector(".mobile-profile");

    if (mobileProfileBtn && mobileProfile) {
        mobileProfileBtn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            mobileProfile.classList.toggle("active");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (!mobileProfile.contains(e.target)) {
                mobileProfile.classList.remove("active");
            }
        });

        // Prevent dropdown from closing when clicking inside
        const mobileDropdown = mobileProfile.querySelector(".mobile-dropdown");
        if (mobileDropdown) {
            mobileDropdown.addEventListener("click", (e) => {
                e.stopPropagation();
            });
        }
    }
});