
const PR = {
  root(){ return (location.pathname.includes('/products/') || location.pathname.includes('/traceability/') || location.pathname.includes('/api/')) ? '../' : './'; },
  page(){ return document.body.dataset.page || 'home'; },
  navLinks:[['home','Home','index.php'],['marketplace','Marketplace','marketplace.php'],['verify','Verify Product','traceability/trace_product.php'],['about','About','about.php'],['contact','Contact','contact.php']],
  dashLinks:[['dashboard','Overview','fa-gauge','dashboard.php'],['products','Product Management','fa-boxes-stacked','products/view_products.php'],['traceability','Traceability','fa-qrcode','traceability/trace_product.php'],['marketplace','Marketplace','fa-store','marketplace.php'],['farmer','Farmer Profile','fa-user-tie','farmer-profile.php'],['admin','Admin Dashboard','fa-shield-halved','dashboard.php'],['analytics','Analytics','fa-chart-line','analytics.php'],['profile','View Profile','fa-id-card','profile.php']],
  products:[
    {name:'Ube Kinampay - Bohol', cat:'Heirloom / Export Grade', province:'Bohol', farmer:'Bohol Ubi Growers Association (BUGA)', price:'₱100-150/kg premium', icon:'🍠', badge:'Verified', harvest:'Apr 18, 2026'},
    {name:'Ube Halaya and Pastries - Quezon', cat:'Processed / Delicacy', province:'Quezon', farmer:'Backyard and cooperative-linked growers', price:'₱40-60/kg standard', icon:'🥣', badge:'Verified', harvest:'Apr 21, 2026'},
    {name:'Fresh Ube Tubers - Pampanga', cat:'Raw Ube / Commercial Supply', province:'Pampanga', farmer:'Commercial root crop farmers', price:'₱40-60/kg standard', icon:'🟣', badge:'Verified', harvest:'May 02, 2026'},
    {name:'Premium Fresh Ube - Batangas', cat:'Premium Fresh Ube', province:'Batangas', farmer:'Direct farmer suppliers', price:'₱80-150/kg premium', icon:'🌋', badge:'Verified', harvest:'May 04, 2026'},
    {name:'Commercial Ube Supply - Bukidnon', cat:'Commercial Root Crop', province:'Bukidnon', farmer:'Commercial growers and landholders', price:'₱40-60/kg standard', icon:'📦', badge:'Verified', harvest:'May 06, 2026'},
    {name:'Ube Planting Materials - Leyte', cat:'Research / Planting Material', province:'Leyte', farmer:'VSU PhilRootcrops partners', price:'Research-based sourcing', icon:'🔬', badge:'Verified', harvest:'May 08, 2026'},
    {name:'Heritage Ube - Antique and Negros Occidental', cat:'Heritage Ube', province:'Western Visayas', farmer:'Heritage growers and traditional farmers', price:'₱40-60/kg standard', icon:'🌾', badge:'Verified', harvest:'May 10, 2026'}
  ]};
function injectNav(){
 const host=document.getElementById('appNavbar'); if(!host) return; const root=PR.root(), page=PR.page();
 const session = window.PR_SESSION || {loggedIn:false, role:'Guest'};
 const authButtons = session.loggedIn
  ? `<a class="btn-pr btn-pr-light" href="${root}profile.php"><i class="fa-solid fa-user"></i> View Profile</a><a class="btn-pr btn-pr-primary" href="${root}logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>`
  : `<a class="btn-pr btn-pr-light" href="${root}login.php">Log in</a><a class="btn-pr btn-pr-primary" href="${root}register.php">Join platform</a>`;
 host.innerHTML=`<nav class="navbar navbar-expand-lg navbar-pr"><div class="container"><a class="navbar-brand d-flex align-items-center gap-2" href="${root}index.php"><img src="${root}uploads/logo.png" alt="PurpleRoots" style="height:42px;width:auto;border-radius:14px;object-fit:contain"><span>PurpleRoots</span></a><button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"><span class="navbar-toggler-icon"></span></button><div class="collapse navbar-collapse" id="navMenu"><ul class="navbar-nav mx-auto gap-lg-1 my-3 my-lg-0">${PR.navLinks.map(x=>`<li class="nav-item"><a class="nav-link ${page===x[0]?'active':''}" href="${root+x[2]}">${x[1]}</a></li>`).join('')}</ul><div class="d-flex gap-2 align-items-center flex-wrap"><button class="dark-mode-toggle" id="darkToggle" title="Toggle dark mode" aria-label="Toggle dark mode">🌙</button>${authButtons}</div></div></div></nav>`;
}
function injectFooter(){
 const host=document.getElementById('appFooter'); if(!host) return; const root=PR.root();
 host.innerHTML=`<footer class="footer"><div class="container"><div class="row g-4"><div class="col-lg-5"><div class="d-flex align-items-center gap-2 mb-3"><img src="${root}uploads/logo.png" alt="PurpleRoots" style="height:42px;width:auto;border-radius:14px;object-fit:contain"><h4 class="mb-0 text-white fw-black">PurpleRoots</h4></div><p class="mb-0">A digital traceability and fair-trade platform for authentic Philippine-grown ube products, farmer empowerment, and cultural preservation.</p></div><div class="col-6 col-lg-2"><h6 class="text-white">Platform</h6><a class="d-block mb-2" href="${root}marketplace.php">Marketplace</a><a class="d-block mb-2" href="${root}traceability/trace_product.php">Verify QR</a><a class="d-block mb-2" href="${root}dashboard.php">Dashboard</a></div><div class="col-6 col-lg-2"><h6 class="text-white">Company</h6><a class="d-block mb-2" href="${root}about.php">About</a><a class="d-block mb-2" href="${root}contact.php">Contact</a><a class="d-block mb-2" href="${root}register.php">Register</a></div><div class="col-lg-3"><h6 class="text-white">Platform focus</h6><p class="small mb-0">Connecting Philippine ube farmers, cooperatives, processors, sellers, and buyers through traceable product records and regional source profiles.</p></div></div><hr class="border-light opacity-25 my-4"><div class="d-flex flex-column flex-md-row justify-content-between gap-2 small"><span>© 2026 PurpleRoots / UBECHAIN. All rights reserved.</span><span>Built for Philippine agriculture, sustainability, and traceability.</span></div></div></footer>`;
}
function injectSidebar(){
 const host=document.getElementById('appSidebar'); if(!host) return; const root=PR.root(), page=PR.page();
 host.innerHTML=`<aside class="sidebar"><div class="d-none d-lg-block mb-4"><div class="eyebrow"><span class="dot"></span> Workspace</div></div>${PR.dashLinks.map(x=>`<a class="${page===x[0]?'active':''}" href="${root}${x[3]}"><i class="fa-solid ${x[2]}"></i><span>${x[1]}</span></a>`).join('')}</aside>`;
}
function renderProducts(){
 document.querySelectorAll('[data-product-grid]').forEach(grid=>{
  const limit=Number(grid.dataset.limit||PR.products.length); const items=PR.products.slice(0,limit);
  grid.innerHTML=items.map((p,i)=>`<div class="col-sm-6 col-xl-4 product-item" data-category="${p.cat}" data-province="${p.province}"><div class="product-card"><div class="product-img"><span>${p.icon}</span><span class="position-absolute top-0 end-0 m-3 ${p.badge==='Verified'?'badge-verified':'chip'}"><i class="fa-solid ${p.badge==='Verified'?'fa-circle-check':'fa-clock'}"></i> ${p.badge}</span></div><div class="p-4"><div class="d-flex justify-content-between gap-2 mb-2"><span class="chip">${p.cat}</span><span class="text-muted small">${p.province}</span></div><h5 class="fw-bold mb-1">${p.name}</h5><p class="text-muted small mb-3">From ${p.farmer}. Harvested ${p.harvest}.</p><div class="d-flex align-items-center justify-content-between"><strong class="gradient-text">${p.price}</strong><button class="btn-pr btn-pr-light btn-sm" data-toast="Inquiry sent for ${p.name}">Inquire</button></div></div></div></div>`).join('');
 });
}
function filterProducts(){
 const search=document.querySelector('[data-search-products]'); const category=document.querySelector('[data-category-filter]');
 if(!search && !category) return;
 function apply(){ const q=(search?.value||'').toLowerCase(); const c=category?.value||''; document.querySelectorAll('.product-item').forEach(item=>{const text=item.textContent.toLowerCase(); const okQ=text.includes(q); const okC=!c || item.dataset.category===c; item.style.display=okQ&&okC?'':'none';}); }
 search?.addEventListener('input',apply); category?.addEventListener('change',apply);
}
function counters(){document.querySelectorAll('[data-counter]').forEach(el=>{let target=parseFloat(el.dataset.counter),suffix=el.dataset.suffix||'';let n=0,step=target/36;let t=setInterval(()=>{n+=step;if(n>=target){n=target;clearInterval(t)}el.textContent=(target%1?n.toFixed(1):Math.round(n).toLocaleString())+suffix},30)})}
function toastInit(){document.addEventListener('click',e=>{const btn=e.target.closest('[data-toast]'); if(!btn)return; const toast=document.querySelector('.toast-pr')||Object.assign(document.body.appendChild(document.createElement('div')),{className:'toast-pr'}); toast.innerHTML=`<strong class="d-block">PurpleRoots</strong><span>${btn.dataset.toast}</span>`; toast.style.display='block'; setTimeout(()=>toast.style.display='none',2800);});}
function verifyDemo(){const form=document.querySelector('[data-verify-form]'); if(!form)return; form.addEventListener('submit',e=>{e.preventDefault(); document.querySelector('[data-verify-result]').classList.remove('d-none'); const toast=document.querySelector('.toast-pr')||Object.assign(document.body.appendChild(document.createElement('div')),{className:'toast-pr'}); toast.innerHTML='<strong class="d-block">Verification complete</strong><span>Product record matched with a registered farmer profile.</span>'; toast.style.display='block'; setTimeout(()=>toast.style.display='none',2800);});}
function productModal(){const modal=document.getElementById('productModal'); if(!modal)return; document.querySelectorAll('[data-open-product-modal]').forEach(b=>b.addEventListener('click',()=>new bootstrap.Modal(modal).show()));}
document.addEventListener('DOMContentLoaded',()=>{
  // Dark mode: apply saved preference before anything renders
  (function(){
    const saved = localStorage.getItem('pr-theme');
    if(saved === 'dark') document.documentElement.setAttribute('data-theme','dark');
  })();

  injectNav();injectFooter();injectSidebar();renderProducts();filterProducts();counters();toastInit();verifyDemo();productModal();

  // Wire up dark mode toggle (injected by injectNav)
  document.addEventListener('click', e => {
    const btn = e.target.closest('#darkToggle');
    if (!btn) return;
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    if (isDark) {
      document.documentElement.removeAttribute('data-theme');
      localStorage.setItem('pr-theme', 'light');
      btn.textContent = '🌙';
      btn.title = 'Switch to dark mode';
    } else {
      document.documentElement.setAttribute('data-theme', 'dark');
      localStorage.setItem('pr-theme', 'dark');
      btn.textContent = '☀️';
      btn.title = 'Switch to light mode';
    }
  });

  // Sync toggle icon to current state after nav is injected
  const toggle = document.getElementById('darkToggle');
  if (toggle && document.documentElement.getAttribute('data-theme') === 'dark') {
    toggle.textContent = '☀️';
    toggle.title = 'Switch to light mode';
  }
});
