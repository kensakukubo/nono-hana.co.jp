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
  
    // Splide.js：ヒーロースライダー
    if (document.getElementById('heroSlider')) {
      new Splide('#heroSlider', {
        type       : 'fade',
        autoplay   : true,
        interval   : 5000,
        arrows     : false,
        pagination : true,
        pauseOnHover: false,
      }).mount();
    }
  
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