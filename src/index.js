import "../assets/css/style.scss";
// import '../assets/css/single-review.scss';
// import '../assets/css/single-bonus.scss';
// import '../assets/css/single-streamer.scss';
// import '../assets/css/search-results.scss';
// import '../assets/css/message.scss';
// import '../assets/css/404.scss';

import SidebarMenu from "./modules/SidebarMenu";
import ArchiveReview from "./modules/ArchiveReview";
import BonusCode from "./modules/BonusCode";
import ShowMore from "./modules/ShowMore";
import SearchResults from "./modules/SearchResults";
import TaxonomyLoadMore from "./modules/TaxonomyLoadMore";
import Patterns from "./modules/Patterns";
import { desktopMenu } from './modules/DesktopMenu';
import { singleReview } from "./modules/SingleReview";
import { kunmingCard } from "./modules/KunmingCard";
import tableToggle from "./modules/TableToggle";
import Faqs from "./modules/Faqs";

// const cardFocus = new CardFocus()
const sidebarMenu = new SidebarMenu()
const bonusCode = new BonusCode()
const showMore = new ShowMore()

// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import feather from 'feather-icons';

document.addEventListener('DOMContentLoaded', function () {
  feather.replace();

  if (document.querySelector('body.search')) {
    const searchResults = new SearchResults()
  }

  if (document.querySelector('.pattern')) {
    const patterns = new Patterns();
  }

  if (document.querySelector('.faq__toggle')) {
    new Faqs();
  }

  if (document.querySelector('body.single-review')) {
    singleReview();
  }

  if (document.querySelector('.card-kunming, .card-suzhou')) {
    kunmingCard();
  }

  if (document.querySelector('.post-template-power-index')) {
    tableToggle();
  }

  desktopMenu();

  if (document.querySelector('#km-card-list')) {
    new TaxonomyLoadMore();
  }

  if (document.querySelector('#review-search')) {
    new ArchiveReview();
  }

  const swiper = new Swiper('.swiper-primary', {
    // Optional parameters
    modules: [Navigation, Pagination],
    slidesPerView: 1.1,
    spaceBetween: 10,
    breakpoints: {
      // 425: {
      //   slidesPerView: 2.1,
      // },
      768: {
        slidesPerView: 2.1,
      },
      992: {
        slidesPerView: 3.1,
      }
    },
    direction: 'horizontal',
    loop: false,
    // If we need paginationc
    pagination: {
      el: '.swiper-pagination',
    },
    verticalClass: '.mt-4',
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    }
  });

});