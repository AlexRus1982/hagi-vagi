<nav class="navbar navbar-expand-lg border-bottom start">
  <div class="container-fluid p-2 py-0" style="max-width: 1200px;">
    
    <a class="navbar-brand ms-1" href="/">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-bootstrap-fill" viewBox="0 0 16 16">
            <path d="M6.375 7.125V4.658h1.78c.973 0 1.542.457 1.542 1.237 0 .802-.604 1.23-1.764 1.23H6.375zm0 3.762h1.898c1.184 0 1.81-.48 1.81-1.377 0-.885-.65-1.348-1.886-1.348H6.375v2.725z"/>
            <path d="M4.002 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4h-8zm1.06 12V3.545h3.399c1.587 0 2.543.809 2.543 2.11 0 .884-.65 1.675-1.483 1.816v.1c1.143.117 1.904.931 1.904 2.033 0 1.488-1.084 2.396-2.888 2.396H5.062z"/>
        </svg>
    </a>    

    <button class="navbar-toggler me-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <ul class="navbar-nav justify-content-start flex-grow-1">
        
        {{--
        @if (!Route::is('main'))
          <li class="nav-item">
            <a class="nav-link" href="/" style="width: fit-content;">
              Главная
            </a>
          </li>
        @endif
        --}}

        @if (Route::is('main'))
          <? $parentId = 0; ?>
        @else
          <? 
            if(isset($id)) {
              $parentId = $id; 
            }
            else {
              $parentId = 0;
            }
          ?>
        @endif

        <?php
          $categories = DB::table('categories')
          ->join('hierarchy_category', 'categories.id', '=', 'hierarchy_category.category_id')
          ->where('parent_id', $parentId)
          ->orderBy('order_place')
          ->get();

          $dropToggle = (count($categories) > 0) ? "dropdown-toggle" : "";
          $dropMenu = (count($categories) > 0) ? true : false;
        ?>

        <li class="nav-item dropdown">
          <a class="nav-link {{$dropToggle}}" href="/products" role="button" aria-expanded="false" style="width: fit-content;">
            Каталог
          </a>
          @if ($dropMenu)
            <ul class="dropdown-menu shadow" style="width: fit-content;">
              <?php
                foreach($categories as $category){
                  ?>
                    <li><a class='dropdown-item' href='/products/{{$category->url}}'>{{$category->category_name}}</a></li>
                  <?
                }
              ?>
            </ul>
          @endif
        </li>

        {{--
        <li class="nav-item dropdown">
          <a class="nav-link" href="/products" style="width: fit-content;">
            Каталог
          </a>
        </li>
        --}}

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: fit-content;">
            Услуги
          </a>
          <ul class="dropdown-menu shadow" style="width: fit-content;">
            @php
              $items = DB::table('services')->get();
              foreach($items as $key => $value){
                $value = (array)$value;
                $pageUrl = "/service/{$value['url']}";
                $pageName = $value['page_name'];
                echo "<li><a class='dropdown-item' href='{$pageUrl}'>{$pageName}</a></li>";
              }
            @endphp
          </ul>
        </li>

      </ul>

      <form class="d-flex mb-0" role="search" method="GET" action="{{route('search')}}">
        <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="Поиск" style="height: 34px; padding: 5px 5px 7px 8px;" name="searchProducts">
        <button class="btn btn-outline-primary" type="submit" style="margin: 0px 0px 0px 0px; padding: 2px 10px 5px 10px; height: 34px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
          </svg>
        </button>
      </form>

      <ul class="navbar-nav justify-content-end ms-1">
        
        <li class="nav-item dropdown">
          <a class="social nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: fit-content;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
              <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
            </svg>
          </a>
          <ul class="dropdown-menu shadow" style="right: 0px; left: auto;">
            <li><a class="dropdown-item" href="#">Telegram</a></li>
            <li><a class="dropdown-item" href="#">WhatsApp</a></li>
            <li><a class="dropdown-item" href="#">E-mail</a></li>
          </ul>
        </li>

      </ul>

    </div>

  </div>
</nav>
<style>
  nav.start {
    transform: translateY(-80px);
  }

  nav {
    transition: 0.3s;
    transform: translateY(0px);
    z-index: 1;
  }

  .navbar-brand {
    transition: 0.3s;
  }

  .navbar-brand:hover {
    cursor: pointer;
    color: #7F7FFF;
    transform: scale(1.1) rotateZ(-10deg);
  }

  .social svg {
    transition: 0.3s;
  } 

  .social:hover svg {
    color: #7F7FFF;
    transform: scale(1.2);
  }

  .nav-link {
    transition: 0.3s;
  }

  .nav-link:hover {
    color: #7F7FFF;
    text-shadow: 0px 0px 3px #7F7FFF;
  }

  .dropdown:hover .dropdown-menu {
    display: block;
    margin-top: 0;
  }
</style>