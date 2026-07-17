(() => {
  // src/js/main.js
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
        item.parentElement?.querySelectorAll(".faq-item.is-open").forEach((openItem) => openItem.classList.remove("is-open"));
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
          void content.offsetWidth;
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
      timer = setInterval(() => goTo(index + 1), 6e3);
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
  function initResponsiveSlider({ rootAttr, trackAttr, prevAttr, nextAttr, dotsAttr, dotClass, base, breakpoints, autoplay = 0 }) {
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
        dot.addEventListener("click", () => {
          goTo(i);
          startAutoplay();
        });
        dotsWrap.appendChild(dot);
      }
    };
    let timer = null;
    const startAutoplay = () => {
      stopAutoplay();
      if (!autoplay || slides.length < 2) return;
      timer = setInterval(() => goTo(index >= maxIndex ? 0 : index + 1), autoplay);
    };
    const stopAutoplay = () => {
      if (timer) {
        clearInterval(timer);
        timer = null;
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
    prevBtn?.addEventListener("click", () => {
      goTo(index - 1);
      startAutoplay();
    });
    nextBtn?.addEventListener("click", () => {
      goTo(index + 1);
      startAutoplay();
    });
    let dragging = false;
    let dragStartX = 0;
    let dragDelta = 0;
    track.style.touchAction = "pan-y";
    track.style.cursor = "pointer";
    track.addEventListener("dragstart", (e) => e.preventDefault());
    track.addEventListener("pointerdown", (e) => {
      dragging = true;
      dragStartX = e.clientX;
      dragDelta = 0;
      stopAutoplay();
      track.setPointerCapture(e.pointerId);
      track.style.transition = "none";
    });
    track.addEventListener("pointermove", (e) => {
      if (!dragging) return;
      dragDelta = e.clientX - dragStartX;
      track.style.transform = `translateX(calc(-${index * (100 / visible)}% + ${dragDelta}px))`;
    });
    const endDrag = () => {
      if (!dragging) return;
      dragging = false;
      track.style.transition = "";
      const threshold = Math.min(80, track.clientWidth / visible / 4);
      if (dragDelta <= -threshold) goTo(index + 1);
      else if (dragDelta >= threshold) goTo(index - 1);
      else render();
      startAutoplay();
    };
    track.addEventListener("pointerup", endDrag);
    track.addEventListener("pointercancel", endDrag);
    track.addEventListener(
      "click",
      (e) => {
        if (Math.abs(dragDelta) > 8) {
          e.preventDefault();
          e.stopPropagation();
        }
      },
      true
    );
    root.addEventListener("mouseenter", stopAutoplay);
    root.addEventListener("mouseleave", () => {
      if (!dragging) startAutoplay();
    });
    let resizeTimer = null;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(recalc, 150);
    });
    recalc();
    startAutoplay();
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
      timer = setInterval(() => goTo(index + 1), 7e3);
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
        { width: 640, count: 2 }
      ]
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
      autoplay: 2e3,
      breakpoints: [
        { width: 1536, count: 4 },
        { width: 768, count: 3 },
        { width: 640, count: 2 }
      ]
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
        { width: 640, count: 2 }
      ]
    });
  }
  function initAwardsSlider() {
    const slider = document.querySelector("[data-awards-slider]");
    const track = document.querySelector("[data-awards-track]");
    const original = track ? Array.from(track.children) : [];
    if (!slider || !track || original.length < 2) return;
    const INTERVAL_MS = 3e3;
    const TRANSITION = "transform 0.45s cubic-bezier(0.65, 0, 0.35, 1)";
    const total = original.length;
    original.forEach((card) => {
      const clone = card.cloneNode(true);
      clone.setAttribute("aria-hidden", "true");
      clone.querySelectorAll("a").forEach((a) => a.setAttribute("tabindex", "-1"));
      track.appendChild(clone);
    });
    const cards = Array.from(track.children);
    let index = 0;
    let timer = null;
    let step = 0;
    const measureStep = () => {
      const style = getComputedStyle(track);
      const gap = parseFloat(style.columnGap || style.gap || "0");
      step = cards[0].offsetWidth + gap;
    };
    const setActive = (i) => {
      cards.forEach((card, ci) => card.classList.toggle("is-active", ci === i));
    };
    const goTo = (i, instant) => {
      track.style.transition = instant ? "none" : TRANSITION;
      track.style.transform = `translateX(-${i * step}px)`;
    };
    track.addEventListener("transitionend", (e) => {
      if (e.propertyName !== "transform" || index < total) return;
      index = 0;
      setActive(index);
      goTo(index, true);
      void track.offsetWidth;
    });
    const tick = () => {
      index += 1;
      setActive(index);
      goTo(index, false);
    };
    const start = () => {
      stop();
      timer = setInterval(tick, INTERVAL_MS);
    };
    const stop = () => {
      if (timer) clearInterval(timer);
    };
    measureStep();
    setActive(index);
    goTo(index, true);
    start();
    slider.addEventListener("mouseenter", stop);
    slider.addEventListener("mouseleave", start);
    let resizeTimer = null;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        measureStep();
        goTo(index, true);
      }, 150);
    });
  }
  function initStickySidebar() {
    const sidebar = document.querySelector("[data-sticky-sidebar]");
    if (!sidebar) return;
    const HEADER_OFFSET = 110;
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
    window.addEventListener("load", update);
    update();
  }
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
  function initScrollReveal() {
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
    const GROUP = /__(grid|list|timeline|posts|cards|features|items)\b/;
    const units = [];
    const addUnit = (el, delay) => {
      el.classList.add("reveal");
      if (delay) el.style.transitionDelay = `${delay}ms`;
      units.push(el);
    };
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
      if (section.matches(".hero, .page-header")) return;
      const roots = section.querySelectorAll(":scope > .container");
      const parents = roots.length ? Array.from(roots) : [section];
      parents.forEach((root) => {
        Array.from(root.children).forEach((child) => collect(child, 0));
      });
    });
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
    initAwardsSlider();
    initStickySidebar();
    initGalleryLightbox();
    initScrollReveal();
  });
})();
