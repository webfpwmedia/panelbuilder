document.querySelectorAll('.fq-tabs').forEach(fqTabs => {

    // Set the first tab to active.
    fqTabs.querySelectorAll('.tab:first-child').forEach(tab => {
        tab.classList.add('active');
    });

    // Setup switching tabs.
    fqTabs.querySelectorAll('.tab-nav .tab').forEach((tab,index) => {
        tab.addEventListener('click', () => {
            // Toggle the nav tabs.
            fqTabs.querySelectorAll('.tab-nav .tab').forEach((navTab, navIndex) => {
                if (index == navIndex) {
                    navTab.classList.add('active');
                } else {
                    navTab.classList.remove('active');
                }
            });

            // Toggle the tabs themselves.
            fqTabs.querySelectorAll('.tabs-container .tab').forEach((tabItem, tabIndex) => {
                if (index == tabIndex) {
                    tabItem.classList.add('active');
                } else {
                    tabItem.classList.remove('active');
                }
            });
        });
    });
});