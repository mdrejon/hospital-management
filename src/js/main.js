function initSidePanel() {
  const toggleBtn = document.querySelector("[data-menu-toggle]");
  const closeBtn = document.querySelector("[data-panel-close]");
  const panel = document.querySelector("[data-side-panel]");
  const overlay = document.querySelector("[data-panel-overlay]");

  if (!toggleBtn || !panel || !overlay) return;

  const openPanel = () => {
    panel.classList.add("is-open");
    overlay.classList.add("is-open");
    document.body.classList.add("overflow-hidden");
  };

  const closePanel = () => {
    panel.classList.remove("is-open");
    overlay.classList.remove("is-open");
    document.body.classList.remove("overflow-hidden");
  };

  toggleBtn.addEventListener("click", openPanel);
  closeBtn?.addEventListener("click", closePanel);
  overlay.addEventListener("click", closePanel);

  document.querySelectorAll("[data-submenu-toggle]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const submenu = btn.nextElementSibling;
      if (submenu) submenu.classList.toggle("is-open");
      btn.classList.toggle("is-open");
    });
  });
}

function initFaqAccordion() {
  document.querySelectorAll("[data-faq-toggle]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const item = btn.closest(".faq-item");
      if (!item) return;
      const wasOpen = item.classList.contains("is-open");
      item.parentElement
        ?.querySelectorAll(".faq-item.is-open")
        .forEach((openItem) => openItem.classList.remove("is-open"));
      if (!wasOpen) item.classList.add("is-open");
    });
  });
}

function initHeroSlider() {
  const hero = document.querySelector("[data-hero]");
  const track = document.querySelector("[data-hero-track]");
  const slides = track ? Array.from(track.children) : [];
  const prevBtn = document.querySelector("[data-hero-prev]");
  const nextBtn = document.querySelector("[data-hero-next]");
  const dots = Array.from(document.querySelectorAll("[data-hero-dot]"));

  if (!hero || !track || slides.length < 1) return;

  let index = 0;
  let timer = null;

  const setActiveContent = (activeIndex) => {
    slides.forEach((slide, i) => {
      const content = slide.querySelector("[data-hero-content]");
      if (!content) return;
      content.classList.remove("is-active");
      if (i === activeIndex) {
        void content.offsetWidth; // force reflow so the entrance animation replays every time
        content.classList.add("is-active");
      }
    });
  };

  const render = () => {
    track.style.transform = `translateX(-${index * 100}%)`;
    dots.forEach((dot, i) => dot.classList.toggle("is-active", i === index));
    setActiveContent(index);
  };

  const goTo = (nextIndex) => {
    index = (nextIndex + slides.length) % slides.length;
    render();
  };

  const startAutoplay = () => {
    stopAutoplay();
    timer = setInterval(() => goTo(index + 1), 6000);
  };

  const stopAutoplay = () => {
    if (timer) clearInterval(timer);
  };

  prevBtn?.addEventListener("click", () => {
    goTo(index - 1);
    startAutoplay();
  });

  nextBtn?.addEventListener("click", () => {
    goTo(index + 1);
    startAutoplay();
  });

  dots.forEach((dot, i) => {
    dot.addEventListener("click", () => {
      goTo(i);
      startAutoplay();
    });
  });

  hero.addEventListener("mouseenter", stopAutoplay);
  hero.addEventListener("mouseleave", startAutoplay);

  render();
  startAutoplay();
}

// Shared engine behind any "N cards visible, responsive by breakpoint"
// slider (team doctors, health packages, ...). `breakpoints` is a list of
// { width, count } sorted descending; whichever is the first matching
// min-width wins, falling back to `base`.
function initResponsiveSlider({ rootAttr, trackAttr, prevAttr, nextAttr, dotsAttr, dotClass, base, breakpoints }) {
  const root = document.querySelector(`[${rootAttr}]`);
  const track = document.querySelector(`[${trackAttr}]`);
  const slides = track ? Array.from(track.children) : [];
  const prevBtn = document.querySelector(`[${prevAttr}]`);
  const nextBtn = document.querySelector(`[${nextAttr}]`);
  const dotsWrap = document.querySelector(`[${dotsAttr}]`);

  if (!root || !track || slides.length < 1) return;

  let index = 0;
  let visible = base;
  let maxIndex = 0;

  const getVisible = () => {
    for (const bp of breakpoints) {
      if (window.matchMedia(`(min-width: ${bp.width}px)`).matches) return bp.count;
    }
    return base;
  };

  const updateNav = () => {
    prevBtn?.classList.toggle("is-disabled", index === 0);
    nextBtn?.classList.toggle("is-disabled", index === maxIndex);
  };

  const updateDots = () => {
    if (!dotsWrap) return;
    Array.from(dotsWrap.children).forEach((dot, i) => dot.classList.toggle("is-active", i === index));
  };

  const render = () => {
    track.style.transform = `translateX(-${index * (100 / visible)}%)`;
    updateNav();
    updateDots();
  };

  const goTo = (nextIndex) => {
    index = Math.min(Math.max(nextIndex, 0), maxIndex);
    render();
  };

  const buildDots = () => {
    if (!dotsWrap) return;
    dotsWrap.innerHTML = "";
    for (let i = 0; i <= maxIndex; i++) {
      const dot = document.createElement("button");
      dot.type = "button";
      dot.className = dotClass;
      dot.setAttribute("aria-label", `Go to slide group ${i + 1}`);
      dot.addEventListener("click", () => goTo(i));
      dotsWrap.appendChild(dot);
    }
  };

  const recalc = () => {
    const newVisible = getVisible();
    const newMaxIndex = Math.max(0, slides.length - newVisible);
    if (newVisible === visible && newMaxIndex === maxIndex) return;
    visible = newVisible;
    maxIndex = newMaxIndex;
    index = Math.min(index, maxIndex);
    buildDots();
    render();
  };

  prevBtn?.addEventListener("click", () => goTo(index - 1));
  nextBtn?.addEventListener("click", () => goTo(index + 1));

  let resizeTimer = null;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(recalc, 150);
  });

  recalc();
}

function initTestimonialsSlider() {
  const root = document.querySelector("[data-testimonials-slider]");
  const track = document.querySelector("[data-testimonials-track]");
  const slides = track ? Array.from(track.children) : [];
  const prevBtn = document.querySelector("[data-testimonials-prev]");
  const nextBtn = document.querySelector("[data-testimonials-next]");
  const dotsWrap = document.querySelector("[data-testimonials-dots]");

  if (!root || !track || slides.length < 1) return;

  let index = 0;
  let timer = null;

  const updateDots = () => {
    if (!dotsWrap) return;
    Array.from(dotsWrap.children).forEach((dot, i) => dot.classList.toggle("is-active", i === index));
  };

  const render = () => {
    track.style.transform = `translateX(-${index * 100}%)`;
    updateDots();
  };

  const goTo = (nextIndex) => {
    index = (nextIndex + slides.length) % slides.length;
    render();
  };

  const buildDots = () => {
    if (!dotsWrap) return;
    dotsWrap.innerHTML = "";
    slides.forEach((_, i) => {
      const dot = document.createElement("button");
      dot.type = "button";
      dot.className = "testimonials__dot";
      dot.setAttribute("aria-label", `Go to testimonial ${i + 1}`);
      dot.addEventListener("click", () => {
        goTo(i);
        startAutoplay();
      });
      dotsWrap.appendChild(dot);
    });
  };

  const startAutoplay = () => {
    stopAutoplay();
    if (slides.length < 2) return;
    timer = setInterval(() => goTo(index + 1), 7000);
  };

  const stopAutoplay = () => {
    if (timer) clearInterval(timer);
  };

  prevBtn?.addEventListener("click", () => {
    goTo(index - 1);
    startAutoplay();
  });

  nextBtn?.addEventListener("click", () => {
    goTo(index + 1);
    startAutoplay();
  });

  root.addEventListener("mouseenter", stopAutoplay);
  root.addEventListener("mouseleave", startAutoplay);

  buildDots();
  render();
  startAutoplay();
}

function initTeamSlider() {
  initResponsiveSlider({
    rootAttr: "data-team-slider",
    trackAttr: "data-team-track",
    prevAttr: "data-team-prev",
    nextAttr: "data-team-next",
    dotsAttr: "data-team-dots",
    dotClass: "team__dot",
    base: 1,
    breakpoints: [
      { width: 1024, count: 3 },
      { width: 640, count: 2 },
    ],
  });
}

function initPackagesSlider() {
  initResponsiveSlider({
    rootAttr: "data-packages-slider",
    trackAttr: "data-packages-track",
    prevAttr: "data-packages-prev",
    nextAttr: "data-packages-next",
    dotsAttr: "data-packages-dots",
    dotClass: "packages__dot",
    base: 1,
    breakpoints: [
      { width: 1280, count: 4 },
      { width: 1024, count: 3 },
      { width: 768, count: 3 },
      { width: 640, count: 2 },
    ],
  });
}

function initDepartmentsSlider() {
  initResponsiveSlider({
    rootAttr: "data-departments-slider",
    trackAttr: "data-departments-track",
    prevAttr: "data-departments-prev",
    nextAttr: "data-departments-next",
    dotsAttr: "data-departments-dots",
    dotClass: "departments__dot",
    base: 1,
    breakpoints: [
      { width: 1024, count: 3 },
      { width: 640, count: 2 },
    ],
  });
}

// Sticky blog sidebar. A sidebar that fits in the viewport just sticks
// below the fixed header; one taller than the viewport gets a negative
// sticky top so it scrolls with the page until its BOTTOM edge reaches
// the viewport bottom, then sticks — keeping every widget reachable
// (same behavior as the theme's original theia sticky sidebar).
function initStickySidebar() {
  const sidebar = document.querySelector("[data-sticky-sidebar]");
  if (!sidebar) return;

  const HEADER_OFFSET = 110; // 90px fixed header + breathing room
  const BOTTOM_GAP = 24;
  const media = window.matchMedia("(min-width: 1024px)");

  const update = () => {
    if (!media.matches) {
      sidebar.style.position = "";
      sidebar.style.top = "";
      return;
    }
    const fitTop = window.innerHeight - sidebar.offsetHeight - BOTTOM_GAP;
    sidebar.style.position = "sticky";
    sidebar.style.top = `${Math.min(HEADER_OFFSET, fitTop)}px`;
  };

  let resizeTimer = null;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(update, 150);
  });
  window.addEventListener("load", update); // re-measure once images are in
  update();
}

// Gallery lightbox: any [data-gallery-item] opens the shared [data-lightbox]
// overlay showing its <img>; prev/next cycle through every gallery item,
// Escape / backdrop click closes.
function initGalleryLightbox() {
  const items = Array.from(document.querySelectorAll("[data-gallery-item]"));
  const box = document.querySelector("[data-lightbox]");
  if (!items.length || !box) return;

  const img = box.querySelector("[data-lightbox-img]");
  let index = 0;

  const show = (i) => {
    index = (i + items.length) % items.length;
    const source = items[index].querySelector("img");
    if (!source || !img) return;
    img.src = source.src;
    img.alt = source.alt;
  };

  const open = (i) => {
    show(i);
    box.classList.add("is-open");
    document.body.classList.add("overflow-hidden");
  };

  const close = () => {
    box.classList.remove("is-open");
    document.body.classList.remove("overflow-hidden");
  };

  items.forEach((item, i) => {
    item.addEventListener("click", (e) => {
      e.preventDefault();
      open(i);
    });
  });

  box.querySelector("[data-lightbox-close]")?.addEventListener("click", close);
  box.querySelector("[data-lightbox-prev]")?.addEventListener("click", () => show(index - 1));
  box.querySelector("[data-lightbox-next]")?.addEventListener("click", () => show(index + 1));
  box.addEventListener("click", (e) => {
    if (e.target === box) close();
  });
  document.addEventListener("keydown", (e) => {
    if (!box.classList.contains("is-open")) return;
    if (e.key === "Escape") close();
    if (e.key === "ArrowLeft") show(index - 1);
    if (e.key === "ArrowRight") show(index + 1);
  });
}

// Scroll-reveal: fades/rises page blocks in as they enter the viewport and
// re-hides them on exit, so the animation replays when scrolling both down
// and up. Reveal units are collected automatically on every page: each
// direct child of a section's .container is one unit, and grid/list-style
// wrappers (classes like *__grid, *__list, ...) are split into their
// children with a small stagger. Styling lives in base/_base.scss (.reveal).
function initScrollReveal() {
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

  const GROUP = /__(grid|list|timeline|posts|cards|features|items)\b/;
  const units = [];

  const addUnit = (el, delay) => {
    el.classList.add("reveal");
    if (delay) el.style.transitionDelay = `${delay}ms`;
    units.push(el);
  };

  // Split group wrappers into staggered children, one nesting level deep
  // (e.g. .blog-list__grid > .blog-list__posts > post cards).
  const collect = (el, depth) => {
    if (!(el instanceof HTMLElement)) return;
    const cls = el.getAttribute("class") || "";
    if (depth < 2 && GROUP.test(cls) && el.children.length > 1) {
      Array.from(el.children).forEach((child, i) => {
        if (!(child instanceof HTMLElement)) return;
        const childCls = child.getAttribute("class") || "";
        if (depth + 1 < 2 && GROUP.test(childCls) && child.children.length > 1) {
          collect(child, depth + 1);
        } else {
          addUnit(child, Math.min(i, 6) * 80);
        }
      });
    } else {
      addUnit(el, 0);
    }
  };

  document.querySelectorAll("main > section").forEach((section) => {
    // The hero has its own entrance animation; the breadcrumb banner stays put.
    if (section.matches(".hero, .page-header")) return;
    const roots = section.querySelectorAll(":scope > .container");
    const parents = roots.length ? Array.from(roots) : [section];
    parents.forEach((root) => {
      Array.from(root.children).forEach((child) => collect(child, 0));
    });
  });

  // Footer bands reveal as whole rows.
  document.querySelectorAll(".site-footer > *").forEach((band) => addUnit(band, 0));

  if (!units.length) return;

  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        entry.target.classList.toggle("is-inview", entry.isIntersecting);
      });
    },
    { threshold: 0.1, rootMargin: "0px 0px -60px 0px" }
  );

  units.forEach((el) => io.observe(el));
}

document.addEventListener("DOMContentLoaded", () => {
  initSidePanel();
  initFaqAccordion();
  initHeroSlider();
  initTestimonialsSlider();
  initTeamSlider();
  initPackagesSlider();
  initDepartmentsSlider();
  initStickySidebar();
  initGalleryLightbox();
  initScrollReveal();
});
