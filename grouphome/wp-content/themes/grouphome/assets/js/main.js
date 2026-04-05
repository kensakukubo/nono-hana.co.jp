document.addEventListener('DOMContentLoaded', function () {

    // ヘッダー：スクロールでクラス付与
    const header = document.getElementById('l-header');
    window.addEventListener('scroll', function () {
      if (window.scrollY > 100) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    });
  
    // SCROLLヒント：スクロールで非表示
    const scrollHint = document.querySelector('.hero-scroll-hint');
    if (scrollHint) {
      window.addEventListener('scroll', function () {
        scrollHint.style.opacity = window.scrollY > 200 ? '0' : '1';
      });
    }
  
    // ヒーロースライダー（Splide があれば使用、なければフォールバックでフェード切替）
    const heroSlider = document.getElementById('heroSlider');
    if (heroSlider) {
      if (window.Splide) {
        new Splide('#heroSlider', {
          type        : 'fade',
          autoplay    : true,
          interval    : 5000,
          arrows      : false,
          pagination  : true,
          pauseOnHover: false,
        }).mount();
      } else {
        const slides = heroSlider.querySelectorAll('.hero-slide');
        if (slides.length > 1) {
          let index = 0;
          slides.forEach((s, i) => s.classList.toggle('is-active', i === 0));
          window.setInterval(() => {
            slides[index].classList.remove('is-active');
            index = (index + 1) % slides.length;
            slides[index].classList.add('is-active');
          }, 5000);
        } else if (slides.length === 1) {
          slides[0].classList.add('is-active');
        }
      }
    }
  
    // 室内ギャラリー：1枚表示・手動切替
    document.querySelectorAll('[data-room-slider]').forEach(function (root) {
      var slides = root.querySelectorAll('[data-room-slide]');
      var prev = root.querySelector('[data-room-prev]');
      var next = root.querySelector('[data-room-next]');
      var dots = root.querySelectorAll('[data-room-dot]');
      var curEl = root.querySelector('.facility-room-slider__current');
      var n = slides.length;
      if (n < 1) return;
      var index = 0;
      function show(i) {
        index = (i + n) % n;
        slides.forEach(function (s, j) {
          s.classList.toggle('is-active', j === index);
        });
        dots.forEach(function (d, j) {
          var on = j === index;
          d.classList.toggle('is-active', on);
          d.setAttribute('aria-selected', on ? 'true' : 'false');
        });
        if (curEl) curEl.textContent = String(index + 1);
      }
      if (prev) prev.addEventListener('click', function () { show(index - 1); });
      if (next) next.addEventListener('click', function () { show(index + 1); });
      dots.forEach(function (d) {
        d.addEventListener('click', function () {
          var go = parseInt(d.getAttribute('data-go'), 10);
          if (!isNaN(go)) show(go);
        });
      });
    });
  
    // IntersectionObserver：フェードイン
    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
        }
      });
    }, { threshold: 0.1 });
  
    document.querySelectorAll('section').forEach(function (el) {
      el.classList.add('fade-in');
      observer.observe(el);
    });
  
  });