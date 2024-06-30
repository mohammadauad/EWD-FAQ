const accordions = document.querySelectorAll('.accordion');

accordions.forEach((accordion) => {
  const header = accordion.querySelector('.accordion-header');
  const body = accordion.querySelector('.accordion-body');

  header.addEventListener('click', () => {
    body.classList.toggle('active');
    header.classList.toggle('active');
  });
});


document.addEventListener('DOMContentLoaded', function () {
  adjustSpanWidth();

  window.addEventListener('resize', function () {
      adjustSpanWidth();
  });

  function adjustSpanWidth() {
      const headers = document.querySelectorAll('.accordion-header');
      headers.forEach(header => {
          const span = header.querySelector(':scope > span');
          const svg = header.querySelector('svg');
          if (svg) {
              const svgWidth = svg.getBoundingClientRect().width;
              span.style.width = `calc(100% - ${svgWidth + 15}px)`;
          }
      });
  }
});