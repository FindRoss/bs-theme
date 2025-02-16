<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="top: 30%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="button button__outline button--square close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
              <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
          </span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-inline my-2 my-lg-0 w-100" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
          <div class="input-group input-group-lg w-100">
          <input class="form-control mr-sm-2 modal-search-input" type="search" placeholder="Search" aria-label="Search" value="" name="s" id="s" type="text">
          <button id="searchsubmit" class="button button__primary" value="Search" type="submit">Search</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
