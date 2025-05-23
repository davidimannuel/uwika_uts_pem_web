<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Warehouse App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?=  urlIs("/") ? 'active' : '' ?> "href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=  urlIs("/categories") ? 'active' : '' ?>" href="/categories">Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=  urlIs("/items") ? 'active' : '' ?>" href="/items">Items</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?=  urlIs("/stock-transactions") ? 'active' : '' ?>" href="/stock-transactions">Stock Transactions</a>
        </li>
      </ul>
    </div>
  </div>
</nav>