document.addEventListener('DOMContentLoaded', () => {
  const navLinks = document.querySelectorAll('nav a.nav-link');
  const sections = document.querySelectorAll('main section');
  const navbar = document.querySelector('.navbar');

  const clearActiveLinks = () => {
    navLinks.forEach(link => link.classList.remove('active'));
  };

  // Fungsi scroll untuk highlight nav dan animasi fade-in
  const onScroll = () => {
    const scrollPos = window.scrollY + navbar.offsetHeight + 20;

    if (window.scrollY > 60) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }

    sections.forEach(section => {
      const top = section.offsetTop;
      const bottom = top + section.offsetHeight;

      if (scrollPos >= top && scrollPos < bottom) {
        clearActiveLinks();
        const id = section.id;
        const activeLink = document.querySelector(`nav a[href="#${id}"]`);
        if (activeLink) activeLink.classList.add('active');

        if (!section.classList.contains('visible')) {
          section.classList.add('visible');
        }
      }
    });
  };

  onScroll();
  window.addEventListener('scroll', onScroll);

  navLinks.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const targetId = link.getAttribute('href').substring(1);
      const targetSection = document.getElementById(targetId);
      if (targetSection) {
        window.scrollTo({
          top: targetSection.offsetTop - navbar.offsetHeight,
          behavior: 'smooth',
        });
      }
    });
  });

  // Intersection Observer dengan delay animasi
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
          setTimeout(() => {
            entry.target.classList.add('visible');
          }, index * 150); // delay 150ms tiap section agar muncul berurutan
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15 }
  );

  sections.forEach(section => {
    observer.observe(section);
  });
});
