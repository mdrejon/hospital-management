import '../scss/main.scss';

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
// min-width wins, falling back to `base`. Pass `autoplay` (ms) to advance
// one slide at that interval, looping back to the start; it pauses on
// hover and while dragging. All sliders support pointer dragging.
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

  // Pointer dragging — grab the track with mouse or touch to pull the
  // slider; past a quarter-slide it commits to the next/prev position.
  let dragging = false;
  let captured = false;
  let dragPointerId = null;
  let dragStartX = 0;
  let dragDelta = 0;

  track.style.touchAction = "pan-y";
  track.style.cursor = "pointer";
  track.addEventListener("dragstart", (e) => e.preventDefault());

  track.addEventListener("pointerdown", (e) => {
    dragging = true;
    captured = false;
    dragPointerId = e.pointerId;
    dragStartX = e.clientX;
    dragDelta = 0;
  });

  // Pointer capture is only claimed once the pointer has actually moved
  // past a small threshold. Capturing eagerly on pointerdown would make
  // Chrome retarget the resulting click event to the track element,
  // which silently defeats navigation on links nested inside the slides.
  track.addEventListener("pointermove", (e) => {
    if (!dragging) return;
    dragDelta = e.clientX - dragStartX;
    if (!captured) {
      if (Math.abs(dragDelta) < 5) return;
      captured = true;
      stopAutoplay();
      track.setPointerCapture(dragPointerId);
      track.style.transition = "none";
    }
    track.style.transform = `translateX(calc(-${index * (100 / visible)}% + ${dragDelta}px))`;
  });

  const endDrag = () => {
    if (!dragging) return;
    dragging = false;
    if (!captured) return;
    captured = false;
    track.style.transition = "";
    const threshold = Math.min(80, track.clientWidth / visible / 4);
    if (dragDelta <= -threshold) goTo(index + 1);
    else if (dragDelta >= threshold) goTo(index - 1);
    else render();
    startAutoplay();
  };
  track.addEventListener("pointerup", endDrag);
  track.addEventListener("pointercancel", endDrag);

  // A real drag shouldn't trigger the links inside the slides.
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
    autoplay: 2000,
    breakpoints: [
      { width: 1536, count: 4 },
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

// Awards row: a continuous right-to-left marquee that never stops — not on
// hover either — and that the visitor can also drag left/right by hand. The
// card set is cloned until the track is at least twice the viewport wide, so
// the scroll offset can simply wrap modulo one set's width and the seam is
// never visible. Whichever card currently sits in the front slot gets
// `.is-active` (scaled up via CSS).
// Runs for every [data-awards-slider] on the page (Home + Achievements).
function initAwardsSlider() {
  document.querySelectorAll("[data-awards-slider]").forEach(setupAwardsSlider);
}

function setupAwardsSlider(slider) {
  const track = slider.querySelector("[data-awards-track]");
  const original = track ? Array.from(track.children) : [];
  if (!track || original.length === 0) return;

  const SPEED = 45; // px per second
  const DRAG_THRESHOLD = 4; // px of travel before a pointer press counts as a drag, not a click

  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

  const addSet = () => {
    original.forEach((card) => {
      const clone = card.cloneNode(true);
      clone.setAttribute("aria-hidden", "true");
      clone.querySelectorAll("a").forEach((a) => a.setAttribute("tabindex", "-1"));
      track.appendChild(clone);
    });
  };

  // offsetWidth is the untransformed layout size — unlike
  // getBoundingClientRect(), it ignores the .is-active scale(1.1), so the
  // measurements stay exact no matter which card is currently active.
  let step = 0; // one card + gap
  let setWidth = 0; // width of one full copy of the original cards
  const measure = () => {
    const style = getComputedStyle(track);
    const gap = parseFloat(style.columnGap || style.gap || "0");
    step = original[0].offsetWidth + gap;
    setWidth = step * original.length;

    // Enough copies that the track always covers the visible area twice over.
    let guard = 12;
    while (setWidth > 0 && guard-- > 0 && track.scrollWidth < slider.offsetWidth * 2 + setWidth) {
      addSet();
    }
  };

  let offset = 0; // px the track is shifted left by
  let activeIndex = -1;

  const wrap = (value) => (setWidth > 0 ? ((value % setWidth) + setWidth) % setWidth : 0);

  const render = () => {
    track.style.transform = `translate3d(${-offset}px, 0, 0)`;

    // The card nearest the front slot is the one the offset has just brought
    // into place; rounding keeps a card active for the whole time it is there.
    const cards = track.children;
    const i = step > 0 ? Math.round(offset / step) % cards.length : 0;
    if (i !== activeIndex) {
      if (cards[activeIndex]) cards[activeIndex].classList.remove("is-active");
      if (cards[i]) cards[i].classList.add("is-active");
      activeIndex = i;
    }
  };

  // ── Auto-scroll ──
  let rafId = null;
  let lastTs = 0;

  const frame = (ts) => {
    const delta = lastTs ? Math.min(ts - lastTs, 100) : 0; // clamp: a backgrounded tab shouldn't jump the row
    lastTs = ts;
    if (!dragging) offset = wrap(offset + (SPEED * delta) / 1000);
    render();
    rafId = requestAnimationFrame(frame);
  };

  const start = () => {
    if (rafId !== null || reduceMotion.matches) return;
    lastTs = 0;
    rafId = requestAnimationFrame(frame);
  };

  const stop = () => {
    if (rafId !== null) cancelAnimationFrame(rafId);
    rafId = null;
  };

  // ── Drag ──
  let dragging = false;
  let pointerId = null;
  let startX = 0;
  let startOffset = 0;
  let moved = 0;

  const onPointerDown = (e) => {
    if (e.pointerType === "mouse" && e.button !== 0) return;
    dragging = true;
    pointerId = e.pointerId;
    startX = e.clientX;
    startOffset = offset;
    moved = 0;
    slider.classList.add("is-dragging");
    slider.setPointerCapture?.(pointerId);
  };

  const onPointerMove = (e) => {
    if (!dragging || e.pointerId !== pointerId) return;
    const dx = e.clientX - startX;
    moved = Math.max(moved, Math.abs(dx));
    // Dragging right pulls the row right, i.e. reduces the left shift.
    offset = wrap(startOffset - dx);
    // On touch, `touch-action: pan-y` already yields the horizontal axis to
    // us, which also makes these events non-cancelable — hence the guard.
    if (moved > DRAG_THRESHOLD && e.cancelable) e.preventDefault();
    render();
  };

  const endDrag = (e) => {
    if (!dragging || (e && e.pointerId !== pointerId)) return;
    dragging = false;
    slider.classList.remove("is-dragging");
    // releasePointerCapture throws if the capture never took, so check first.
    if (pointerId !== null && slider.hasPointerCapture?.(pointerId)) {
      slider.releasePointerCapture(pointerId);
    }
    pointerId = null;
    lastTs = 0; // don't let the paused time count as elapsed motion
  };

  slider.addEventListener("pointerdown", onPointerDown);
  slider.addEventListener("pointermove", onPointerMove);
  slider.addEventListener("pointerup", endDrag);
  slider.addEventListener("pointercancel", endDrag);
  slider.addEventListener("dragstart", (e) => e.preventDefault());

  // Swallow the click that ends a drag so it doesn't follow the card's link.
  slider.addEventListener(
    "click",
    (e) => {
      if (moved > DRAG_THRESHOLD) {
        e.preventDefault();
        e.stopPropagation();
        moved = 0;
      }
    },
    true
  );

  measure();
  render();
  start();

  // Pause off-screen / in a hidden tab; nothing to animate and it frees the CPU.
  document.addEventListener("visibilitychange", () => (document.hidden ? stop() : start()));

  if (typeof IntersectionObserver !== "undefined") {
    new IntersectionObserver(
      ([entry]) => (entry.isIntersecting ? start() : stop()),
      { threshold: 0 }
    ).observe(slider);
  }

  reduceMotion.addEventListener?.("change", () => (reduceMotion.matches ? stop() : start()));

  let resizeTimer = null;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      measure();
      offset = wrap(offset);
      render();
    }, 150);
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
// children with a small stagger. Styling lives in resources/scss/base/_base.scss (.reveal).
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

// Video modal lightbox: triggers [data-embed] on any .js-video-trigger
// to open the shared video modal overlay. Escape / close / backdrop click closes.
function initVideoModal() {
  const modal = document.getElementById("videoModal");
  if (!modal) return;

  const iframe = document.getElementById("videoIframe");
  const titleEl = document.getElementById("videoModalTitle");
  const closeBtn = document.getElementById("closeVideoModal");
  const backdrop = document.getElementById("videoModalBackdrop");

  const resolveEmbedUrl = (rawUrl) => {
    if (!rawUrl) return "";
    let url = rawUrl.trim();
    // YouTube detection (watch?v=, youtu.be, embed/)
    const ytMatch = url.match(/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i);
    if (ytMatch && ytMatch[1]) {
      return `https://www.youtube.com/embed/${ytMatch[1]}?autoplay=1&rel=0&enablejsapi=1`;
    }
    // Vimeo detection
    const vimeoMatch = url.match(/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)/);
    if (vimeoMatch && vimeoMatch[vimeoMatch.length - 1]) {
      return `https://player.vimeo.com/video/${vimeoMatch[vimeoMatch.length - 1]}?autoplay=1`;
    }
    return url;
  };

  const openVideo = (embed, title) => {
    if (!embed || !iframe) return;
    iframe.src = resolveEmbedUrl(embed);
    if (titleEl) titleEl.textContent = title || "Video Player";
    modal.classList.add("is-open");
    document.body.classList.add("overflow-hidden");
  };

  const closeVideo = () => {
    modal.classList.remove("is-open");
    if (iframe) iframe.src = "";
    document.body.classList.remove("overflow-hidden");
  };

  document.querySelectorAll(".js-video-trigger").forEach((trigger) => {
    trigger.addEventListener("click", (e) => {
      e.preventDefault();
      const embed = trigger.getAttribute("data-embed");
      const title = trigger.getAttribute("data-title");
      openVideo(embed, title);
    });
  });

  closeBtn?.addEventListener("click", closeVideo);
  backdrop?.addEventListener("click", closeVideo);
  modal.addEventListener("click", (e) => {
    if (e.target === modal) closeVideo();
  });

  document.addEventListener("keydown", (e) => {
    if (!modal.classList.contains("is-open")) return;
    if (e.key === "Escape") closeVideo();
  });
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
  initVideoModal();
  initScrollReveal();
});
