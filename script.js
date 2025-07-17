document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector("header");
  let lastScroll = 0;

  // Sticky header scroll behavior
  window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset;
    if (currentScroll <= 0) {
      header.classList.remove("hide-header", "bg-opacity-80");
      return;
    }
    if (currentScroll > lastScroll) {
      header.classList.add("hide-header");
    } else {
      header.classList.remove("hide-header");
      header.classList.add("bg-opacity-80");
    }
    lastScroll = currentScroll;
  });

  function updateActiveNav(activeHref) {
    document.querySelectorAll("nav a").forEach(link => {
      const href = link.getAttribute("href");
      if (href === activeHref || href === `?view=${activeHref}`) {
        link.classList.add("active");
      } else {
        link.classList.remove("active");
      }
    });
  }

  // Ambil state dari URL
  function getIdeasQueryParams() {
    const urlParams = new URLSearchParams(window.location.search);
    return {
      page: parseInt(urlParams.get("page")) || 1,
      size: parseInt(urlParams.get("size")) || 10,
      sort: urlParams.get("sort") || "-published_at"
    };
  }

  // Update state ke URL tanpa reload
  function updateURLParams(page, size, sort) {
    const url = new URL(window.location);
    url.searchParams.set("view", "ideas.php");
    url.searchParams.set("page", page);
    url.searchParams.set("size", size);
    url.searchParams.set("sort", sort);
    history.replaceState(null, "", url.toString());
  }

  // Load Ideas Page with Query
  function loadIdeasWithQuery(page = 1, size = 10, sort = '-published_at') {
    updateURLParams(page, size, sort);

    fetch(`ideas.php?page=${page}&size=${size}&sort=${sort}`)
      .then(res => {
        if (!res.ok) throw new Error("Gagal mengambil data ideas.php");
        return res.text();
      })
      .then(html => {
        const content = document.getElementById("content");
        content.innerHTML = html;
        window.scrollTo(0, 0);
        updateActiveNav("ideas.php");

        requestAnimationFrame(() => {
          bindIdeasControls();
        });
      })
      .catch(err => {
        document.getElementById("content").innerHTML =
          "<p class='text-red-500'>Gagal memuat konten Ideas.</p>";
      });
  }

  // Bind ulang dropdown dan pagination setelah fetch
  function bindIdeasControls() {
    const showPerPage = document.getElementById("showPerPage");
    const sortBy = document.getElementById("sortBy");

    if (showPerPage && sortBy) {
      showPerPage.addEventListener("change", () => {
        const size = parseInt(showPerPage.value);
        const sort = sortBy.value;
        loadIdeasWithQuery(1, size, sort);
      });

      sortBy.addEventListener("change", () => {
        const size = parseInt(showPerPage.value);
        const sort = sortBy.value;
        loadIdeasWithQuery(1, size, sort);
      });
    }

    document.querySelectorAll(".pagination-btn[href]").forEach(btn => {
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        const url = new URL(this.href);
        const page = parseInt(url.searchParams.get("page")) || 1;
        const size = parseInt(url.searchParams.get("size")) || 10;
        const sort = url.searchParams.get("sort") || '-published_at';
        loadIdeasWithQuery(page, size, sort);
      });
    });

    document.querySelectorAll("img").forEach(img => {
        img.addEventListener("error", () => {
            console.error("Gagal memuat gambar:", img.src);
        });
    });

  }

  // Klik menu navigasi SPA-style
  document.querySelectorAll("nav a").forEach(link => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const href = link.getAttribute("href");
      const pageOnly = href.replace("?view=", "");

      if (pageOnly === "ideas.php") {
        const { page, size, sort } = getIdeasQueryParams();
        loadIdeasWithQuery(page, size, sort);
      } else {
        fetch(pageOnly)
          .then(res => {
            if (!res.ok) throw new Error("Halaman tidak ditemukan");
            return res.text();
          })
          .then(html => {
            document.getElementById("content").innerHTML = html;
            window.scrollTo(0, 0);
            updateActiveNav(href);

            if (pageOnly === "ideas.php") {
              bindIdeasControls();
            }
          })
          .catch(err => {
            document.getElementById("content").innerHTML =
              `<p class="text-red-500">Halaman gagal dimuat: ${err.message}</p>`;
          });
      }
    });
  });

  // Saat halaman pertama kali dibuka
  const urlParam = new URLSearchParams(window.location.search);
  const viewPage = urlParam.get("view") || "ideas.php";

  if (viewPage === "ideas.php") {
    const { page, size, sort } = getIdeasQueryParams();
    loadIdeasWithQuery(page, size, sort);
  } else {
    fetch(viewPage)
      .then(res => res.text())
      .then(html => {
        document.getElementById("content").innerHTML = html;
        updateActiveNav(`?view=${viewPage}`);
        if (viewPage === "ideas.php") {
          bindIdeasControls();
        }
      });
  }
});
