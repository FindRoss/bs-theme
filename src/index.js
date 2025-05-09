// import "../assets/css/style.scss";
// import '../assets/css/single-review.scss';
// import '../assets/css/single-bonus.scss';
// import '../assets/css/single-streamer.scss';


import SidebarMenu from "./modules/SidebarMenu";
import CardFocus from "./modules/CardFocus";
import BonusCode from "./modules/BonusCode";
import ShowMore from "./modules/ShowMore";
import SearchResults from "./modules/SearchResults";
import ToggleFilterModal from "./modules/ToggleFilterModal";
import ExpiryDates from "./modules/ExpiryDates";
import { desktopMenu } from './modules/DesktopMenu';
import { singleReview } from "./modules/SingleReview";

const sidebarMenu = new SidebarMenu()
const cardFocus = new CardFocus()
const bonusCode = new BonusCode()
const showMore = new ShowMore()
const expiryDates = new ExpiryDates()



// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';



document.addEventListener('DOMContentLoaded', function () {
  if (document.querySelector('body.search')) {
    const toggleFilterModal = new ToggleFilterModal()
    const searchResults = new SearchResults()
  }

  if (document.querySelector('body.single-review')) {
    singleReview()
  }

  desktopMenu();


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


  const anotherSwiper = new Swiper(".swiper-big", {
    modules: [Navigation, Pagination],
    slidesPerView: 1.06,
    spaceBetween: 10,
    breakpoints: {
      768: {
        slidesPerView: 1.025,
        // spaceBetween: 10
      }
    },
    pagination: {
      el: ".swiper-pagination",
      // dynamicBullets: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    verticalClass: '.mt-4',
  });
});