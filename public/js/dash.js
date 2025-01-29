document.addEventListener("DOMContentLoaded", () => {
    // Get all navigation links
    const navLinks = document.querySelectorAll(".sidebar nav ul li a")
  
    // Function to remove active class from all links
    function removeAllActive() {
      navLinks.forEach((link) => link.classList.remove("active"))
    }
  
    // Set active class based on current URL
    function setActiveLink() {
      const currentPath = window.location.pathname
  
      navLinks.forEach((link) => {
        const href = link.getAttribute("href")
        if (href === currentPath) {
          removeAllActive()
          link.classList.add("active")
        }
      })
    }
  
    // Set initial active state
    setActiveLink()
  
    // Add click handler to each link

    // Restore active state from localStorage on page load
    const storedActiveLink = localStorage.getItem("activeLink")
    if (storedActiveLink) {
      navLinks.forEach((link) => {
        if (link.getAttribute("href") === storedActiveLink) {
          link.classList.add("active")
        }
      })
    }
  })
  let isCollapsed = false
  const sidebar = document.querySelector(".sidebar")
  const toggleButton = document.createElement("button")
  toggleButton.innerHTML = "☰"
  toggleButton.className = "sidebar-toggle"
  toggleButton.style.cssText = `
        position: absolute;
        top: 1rem;
        right: -1.5rem;
        background: var(--sidebar-bg);
        border: none;
        color: white;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        cursor: pointer;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    `

  sidebar.style.position = "relative"
  sidebar.appendChild(toggleButton)

  toggleButton.addEventListener("click", () => {
    isCollapsed = !isCollapsed
    sidebar.classList.toggle("collapsed")
    toggleButton.style.transform = isCollapsed ? "rotate(180deg)" : "rotate(0deg)"
  })

  
  