<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SearchVault — Smart Text Search</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root {
  --bg-primary:#0c0c18;
  --bg-secondary:#14142a;
  --bg-card:rgba(255,255,255,0.05);
  --bg-card-hover:rgba(255,255,255,0.09);
  --text-primary:#eeeef8;
  --text-secondary:#9898b8;
  --text-muted:#55557a;
  --accent:#7c3aed;
  --accent2:#2563eb;
  --accent-light:#a78bfa;
  --accent-glow:rgba(124,58,237,0.35);
  --hl-bg:rgba(251,191,36,0.28);
  --hl-color:#fbbf24;
  --hl-shadow:rgba(251,191,36,0.45);
  --border:rgba(255,255,255,0.08);
  --neu:4px 4px 12px rgba(0,0,0,0.5),-3px -3px 8px rgba(255,255,255,0.025);
}
[data-theme="light"] {
  --bg-primary:#f0f0fa;
  --bg-secondary:#e6e6f5;
  --bg-card:rgba(255,255,255,0.82);
  --bg-card-hover:rgba(255,255,255,0.97);
  --text-primary:#12122a;
  --text-secondary:#44446a;
  --text-muted:#8888aa;
  --accent:#6d28d9;
  --accent2:#1d4ed8;
  --accent-light:#5b21b6;
  --accent-glow:rgba(109,40,217,0.2);
  --hl-bg:rgba(251,191,36,0.35);
  --hl-color:#92400e;
  --hl-shadow:rgba(251,191,36,0.5);
  --border:rgba(0,0,0,0.09);
  --neu:5px 5px 14px rgba(0,0,0,0.1),-5px -5px 14px rgba(255,255,255,0.85);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}
body{
  font-family:'Inter',sans-serif;
  background:var(--bg-primary);
  color:var(--text-primary);
  min-height:100vh;
  overflow-x:hidden;
  transition:background .4s,color .4s;
}

/* BG */
.bg-wrap{position:fixed;inset:0;z-index:0;overflow:hidden;pointer-events:none;}
.orb{position:absolute;border-radius:50%;filter:blur(90px);animation:orbFloat 22s ease-in-out infinite;}
.o1{width:620px;height:620px;background:radial-gradient(circle,rgba(124,58,237,.55),transparent 70%);top:-200px;left:-180px;animation-delay:0s;}
.o2{width:520px;height:520px;background:radial-gradient(circle,rgba(37,99,235,.5),transparent 70%);top:35%;right:-160px;animation-delay:-8s;}
.o3{width:440px;height:440px;background:radial-gradient(circle,rgba(6,182,212,.45),transparent 70%);bottom:-120px;left:35%;animation-delay:-15s;}
[data-theme="light"] .orb{opacity:.18;}
@keyframes orbFloat{
  0%,100%{transform:translate(0,0) scale(1);}
  33%{transform:translate(45px,-55px) scale(1.06);}
  66%{transform:translate(-35px,45px) scale(0.94);}
}
.noise{
  position:fixed;inset:0;z-index:1;pointer-events:none;opacity:.028;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size:180px 180px;
}

/* LAYOUT */
.content{position:relative;z-index:2;}

/* HEADER */
.header{text-align:center;padding:56px 20px 36px;}
.logo{display:inline-flex;align-items:center;gap:10px;margin-bottom:18px;}
.logo-icon{
  width:50px;height:50px;border-radius:14px;
  background:linear-gradient(135deg,#7c3aed,#2563eb);
  display:flex;align-items:center;justify-content:center;
  font-size:22px;color:#fff;
  box-shadow:0 8px 32px rgba(124,58,237,.45);
}
.logo-text{
  font-family:'Space Grotesk',sans-serif;font-size:26px;font-weight:700;
  background:linear-gradient(135deg,#a78bfa,#60a5fa);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
[data-theme="light"] .logo-text{background:linear-gradient(135deg,#6d28d9,#1d4ed8);-webkit-background-clip:text;background-clip:text;}
.header-title{
  font-family:'Space Grotesk',sans-serif;
  font-size:clamp(26px,5vw,52px);font-weight:800;
  color:var(--text-primary);line-height:1.2;margin-bottom:10px;
}
.header-sub{font-size:15px;color:var(--text-secondary);max-width:480px;margin:0 auto;line-height:1.6;}

/* THEME BTN */
.theme-btn{
  position:fixed;top:18px;right:18px;z-index:200;
  width:44px;height:44px;border-radius:12px;border:1px solid var(--border);
  background:var(--bg-card);backdrop-filter:blur(20px);
  color:var(--text-primary);cursor:pointer;
  display:flex;align-items:center;justify-content:center;font-size:17px;
  box-shadow:var(--neu);transition:all .3s;
}
.theme-btn:hover{transform:scale(1.1);box-shadow:0 0 22px var(--accent-glow);}

/* SEARCH WRAPPER */
.search-wrap{max-width:820px;margin:0 auto;padding:0 18px 24px;}
.search-box{position:relative;margin-bottom:16px;}
.search-row{
  display:flex;align-items:center;
  background:var(--bg-card);border:1.5px solid var(--border);
  border-radius:18px;padding:5px 5px 5px 18px;
  backdrop-filter:blur(24px);
  box-shadow:var(--neu);
  transition:border-color .3s,box-shadow .3s;
}
.search-row:focus-within{
  border-color:var(--accent);
  box-shadow:var(--neu),0 0 0 3px var(--accent-glow),0 12px 40px rgba(0,0,0,.2);
}
.s-icon{color:var(--text-muted);font-size:17px;margin-right:12px;flex-shrink:0;transition:color .3s;}
.search-row:focus-within .s-icon{color:var(--accent-light);}
.s-input{
  flex:1;background:transparent;border:none;outline:none;
  font-size:15px;font-family:'Inter',sans-serif;color:var(--text-primary);
  padding:11px 0;
}
.s-input::placeholder{color:var(--text-muted);}
.s-clear{
  background:transparent;border:none;color:var(--text-muted);
  cursor:pointer;padding:8px 10px;font-size:14px;
  transition:color .2s;display:none;
}
.s-clear:hover{color:var(--text-primary);}
.s-clear.show{display:block;}
.s-btn{
  background:linear-gradient(135deg,#7c3aed,#2563eb);
  border:none;border-radius:12px;color:#fff;
  width:44px;height:44px;cursor:pointer;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;font-size:15px;
  transition:all .3s;box-shadow:0 4px 16px rgba(124,58,237,.45);
}
.s-btn:hover{transform:scale(1.06);box-shadow:0 6px 24px rgba(124,58,237,.65);}

/* SUGGESTIONS */
.sugg-drop{
  position:absolute;top:calc(100% + 8px);left:0;right:0;z-index:60;
  background:var(--bg-secondary);border:1px solid var(--border);
  border-radius:16px;overflow:hidden;
  box-shadow:0 20px 60px rgba(0,0,0,.35);
  display:none;backdrop-filter:blur(20px);
}
.sugg-drop.open{display:block;animation:dropIn .2s ease;}
@keyframes dropIn{from{opacity:0;transform:translateY(-8px);}to{opacity:1;transform:translateY(0);}}
.sugg-item{
  display:flex;align-items:center;gap:12px;padding:11px 16px;
  cursor:pointer;color:var(--text-secondary);font-size:13px;
  transition:background .15s,color .15s;
}
.sugg-item:hover{background:var(--bg-card);color:var(--text-primary);}
.sugg-item i{color:var(--accent-light);width:14px;flex-shrink:0;}
.sugg-cat{margin-left:auto;font-size:11px;opacity:.45;white-space:nowrap;}

/* FILTERS */
.filters{display:flex;gap:7px;flex-wrap:wrap;align-items:center;}
.f-label{font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em;}
.chip{
  padding:5px 13px;border-radius:20px;font-size:12px;font-weight:600;
  cursor:pointer;border:1px solid var(--border);
  background:var(--bg-card);color:var(--text-secondary);
  transition:all .22s;backdrop-filter:blur(10px);
}
.chip:hover{border-color:var(--accent);color:var(--accent-light);}
.chip.on{
  background:linear-gradient(135deg,rgba(124,58,237,.28),rgba(37,99,235,.2));
  border-color:var(--accent);color:var(--accent-light);
}

/* STATS BAR */
.stats-bar{
  display:flex;justify-content:space-between;align-items:center;
  padding:0 18px 14px;max-width:1220px;margin:0 auto;
  flex-wrap:wrap;gap:10px;
}
.res-count{font-size:13px;color:var(--text-muted);}
.res-count b{color:var(--accent-light);}
.bar-right{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.sort-sel{
  background:var(--bg-card);border:1px solid var(--border);border-radius:10px;
  color:var(--text-secondary);font-size:12px;padding:6px 12px;
  cursor:pointer;outline:none;font-family:'Inter',sans-serif;
  backdrop-filter:blur(10px);transition:border-color .2s;
}
.sort-sel:focus{border-color:var(--accent);}
.sort-sel option{background:var(--bg-secondary);}
.vt{display:flex;gap:4px;}
.vbtn{
  width:32px;height:32px;border-radius:8px;border:1px solid var(--border);
  background:var(--bg-card);color:var(--text-muted);cursor:pointer;
  display:flex;align-items:center;justify-content:center;font-size:13px;
  transition:all .2s;
}
.vbtn.on,.vbtn:hover{border-color:var(--accent);color:var(--accent-light);background:rgba(124,58,237,.12);}

/* GRID */
.cards-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(330px,1fr));
  gap:18px;padding:0 18px 60px;max-width:1220px;margin:0 auto;
}
.cards-grid.lv{grid-template-columns:1fr;}
.cards-grid.lv .card{flex-direction:row;gap:18px;align-items:flex-start;}
.cards-grid.lv .card-body{flex:1;min-width:0;}
.cards-grid.lv .card-content{-webkit-line-clamp:2;}

/* CARD */
.card{
  background:var(--bg-card);border:1px solid var(--border);
  border-radius:20px;padding:22px;
  backdrop-filter:blur(22px);
  position:relative;overflow:hidden;cursor:pointer;
  transition:transform .35s cubic-bezier(.34,1.56,.64,1),box-shadow .35s,border-color .35s;
  animation:cardIn .45s ease both;
  display:flex;flex-direction:column;gap:0;
}
@keyframes cardIn{from{opacity:0;transform:translateY(18px) scale(.97);}to{opacity:1;transform:none;}}
.card::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(124,58,237,.04),rgba(37,99,235,.04));
  opacity:0;transition:opacity .3s;border-radius:inherit;
}
.card:hover::after{opacity:1;}
.card:hover{
  transform:translateY(-7px) scale(1.015);
  border-color:rgba(124,58,237,.38);
  box-shadow:0 24px 64px rgba(0,0,0,.28),0 0 0 1px rgba(124,58,237,.18),0 0 44px rgba(124,58,237,.1);
}
.card-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;gap:8px;}
.c-cat{
  display:inline-flex;align-items:center;gap:5px;
  padding:3px 11px;border-radius:20px;font-size:10px;font-weight:700;
  text-transform:uppercase;letter-spacing:.055em;white-space:nowrap;
}
.c-meta{display:flex;align-items:center;gap:7px;font-size:11px;color:var(--text-muted);flex-shrink:0;flex-wrap:wrap;justify-content:flex-end;}
.card-title{
  font-family:'Space Grotesk',sans-serif;font-size:17px;font-weight:700;
  color:var(--text-primary);margin-bottom:9px;line-height:1.35;
}
.card-content{
  font-size:13px;color:var(--text-secondary);line-height:1.72;margin-bottom:14px;
  display:-webkit-box;-webkit-line-clamp:4;-webkit-box-orient:vertical;overflow:hidden;flex:1;
}
.card-footer{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:auto;}
.c-tags{display:flex;gap:5px;flex-wrap:wrap;}
.c-tag{
  padding:3px 9px;border-radius:20px;font-size:10px;font-weight:600;
  background:rgba(124,58,237,.1);border:1px solid rgba(124,58,237,.2);
  color:var(--accent-light);
}
.read-more{
  font-size:11px;color:var(--accent-light);font-weight:700;
  display:flex;align-items:center;gap:4px;white-space:nowrap;
  opacity:0;transform:translateX(-6px);transition:all .3s;
}
.card:hover .read-more{opacity:1;transform:translateX(0);}
.card-date{
  margin-top:11px;padding-top:11px;
  border-top:1px solid var(--border);
  font-size:10px;color:var(--text-muted);
  display:flex;align-items:center;gap:5px;
}

/* HIGHLIGHT */
mark.hl{
  background:var(--hl-bg);color:var(--hl-color);
  border-radius:3px;padding:1px 3px;font-weight:700;
  box-shadow:0 0 8px var(--hl-shadow);
  animation:hlPulse 2.4s ease-in-out infinite;
}
@keyframes hlPulse{
  0%,100%{box-shadow:0 0 4px var(--hl-shadow);}
  50%{box-shadow:0 0 14px var(--hl-shadow);}
}

/* MATCH BADGE */
.mbadge{
  display:inline-flex;align-items:center;gap:4px;
  background:rgba(251,191,36,.14);border:1px solid rgba(251,191,36,.3);
  color:#fbbf24;font-size:10px;font-weight:700;
  padding:2px 8px;border-radius:20px;
}

/* EMPTY */
.empty{text-align:center;padding:80px 20px;grid-column:1/-1;animation:fadeIn .5s ease;}
@keyframes fadeIn{from{opacity:0;}to{opacity:1;}}
.empty-ico{font-size:60px;margin-bottom:18px;animation:bob 2.2s ease-in-out infinite;}
@keyframes bob{0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);}}
.empty-t{font-family:'Space Grotesk',sans-serif;font-size:21px;font-weight:700;color:var(--text-primary);margin-bottom:7px;}
.empty-s{color:var(--text-muted);font-size:13px;}

/* CATEGORY COLORS */
.ct{background:rgba(59,130,246,.14);color:#60a5fa;border:1px solid rgba(59,130,246,.28);}
.cn{background:rgba(132,204,22,.14);color:#a3e635;border:1px solid rgba(132,204,22,.28);}
.cs{background:rgba(16,185,129,.14);color:#34d399;border:1px solid rgba(16,185,129,.28);}
.ch{background:rgba(245,158,11,.14);color:#fbbf24;border:1px solid rgba(245,158,11,.28);}
.ca{background:rgba(236,72,153,.14);color:#f472b6;border:1px solid rgba(236,72,153,.28);}
.chl{background:rgba(239,68,68,.14);color:#f87171;border:1px solid rgba(239,68,68,.28);}
.csp{background:rgba(124,58,237,.18);color:#a78bfa;border:1px solid rgba(124,58,237,.32);}
.ccu{background:rgba(20,184,166,.14);color:#2dd4bf;border:1px solid rgba(20,184,166,.28);}

/* SCROLL */
::-webkit-scrollbar{width:5px;}
::-webkit-scrollbar-track{background:transparent;}
::-webkit-scrollbar-thumb{background:var(--border);border-radius:3px;}
::-webkit-scrollbar-thumb:hover{background:var(--accent);}

@media(max-width:700px){
  .cards-grid{grid-template-columns:1fr;}
  .stats-bar{flex-direction:column;align-items:flex-start;}
  .cards-grid.lv .card{flex-direction:column;}
}
@media(max-width:480px){
  .header{padding:36px 14px 22px;}
  .cards-grid{padding:0 12px 40px;gap:12px;}
  .search-wrap{padding:0 12px 18px;}
}
</style>
</head>
<body>

<!-- BG -->
<div class="bg-wrap" aria-hidden="true">
  <div class="orb o1"></div>
  <div class="orb o2"></div>
  <div class="orb o3"></div>
</div>
<div class="noise" aria-hidden="true"></div>

<!-- THEME -->
<button class="theme-btn" id="themeBtn" aria-label="Toggle theme">
  <i class="fas fa-moon" id="themeIco"></i>
</button>

<div class="content">

  <!-- HEADER -->
  <header class="header">
    <div class="logo">
      <div class="logo-icon"><i class="fas fa-search-plus"></i></div>
      <span class="logo-text">SearchVault</span>
    </div>
    <h1 class="header-title">Find What Matters</h1>
    <p class="header-sub">Real-time search across articles with instant keyword highlighting and smart filtering</p>
  </header>

  <!-- SEARCH -->
  <div class="search-wrap">
    <div class="search-box">
      <div class="search-row" id="searchRow">
        <i class="fas fa-search s-icon"></i>
        <input type="text" class="s-input" id="sInput" placeholder="Search articles, topics, keywords…" autocomplete="off" aria-label="Search articles" spellcheck="false">
        <button class="s-clear" id="sClear" aria-label="Clear"><i class="fas fa-times"></i></button>
        <button class="s-btn" id="sBtn" aria-label="Search"><i class="fas fa-arrow-right"></i></button>
      </div>
      <div class="sugg-drop" id="suggDrop"></div>
    </div>
    <div class="filters" id="filtersEl">
      <span class="f-label"><i class="fas fa-sliders-h" style="font-size:9px;margin-right:3px;"></i>Filter:</span>
      <button class="chip on" data-cat="all">All</button>
      <button class="chip" data-cat="Technology">🖥 Tech</button>
      <button class="chip" data-cat="Science">🔬 Science</button>
      <button class="chip" data-cat="Nature">🌿 Nature</button>
      <button class="chip" data-cat="History">📜 History</button>
      <button class="chip" data-cat="Art">🎨 Art</button>
      <button class="chip" data-cat="Health">❤️ Health</button>
      <button class="chip" data-cat="Space">🚀 Space</button>
      <button class="chip" data-cat="Culture">🌍 Culture</button>
    </div>
  </div>

  <!-- STATS BAR -->
  <div class="stats-bar">
    <div class="res-count">Showing <b id="cntSpan">0</b> articles</div>
    <div class="bar-right">
      <select class="sort-sel" id="sortSel">
        <option value="def">Sort: Default</option>
        <option value="ta">Title A–Z</option>
        <option value="td">Title Z–A</option>
        <option value="dn">Newest First</option>
        <option value="do">Oldest First</option>
      </select>
      <div class="vt">
        <button class="vbtn on" id="gvBtn" title="Grid view"><i class="fas fa-th-large"></i></button>
        <button class="vbtn" id="lvBtn" title="List view"><i class="fas fa-list"></i></button>
      </div>
    </div>
  </div>

  <!-- CARDS -->
  <div class="cards-grid" id="cardsGrid"></div>

</div>

<script>
const DATA = [
  {id:1,title:"The Future of Artificial Intelligence in Everyday Life",
  content:"Artificial intelligence is transforming how we live and work. From smart assistants that understand natural language to algorithms that predict our preferences, AI is becoming the invisible backbone of modern society. Machine learning models now diagnose diseases, compose music, write code, and generate photorealistic images from text. Neural networks and deep learning keep pushing the boundary of what machines can achieve, reshaping every industry from healthcare to finance.",
  cat:"Technology",date:"2025-03-15",rt:"5 min",tags:["AI","Machine Learning","Innovation"]},

  {id:2,title:"Ocean Depths: Life in the Abyssal Zone",
  content:"The abyssal zone, between 3,000 and 6,000 meters below the ocean surface, is one of Earth's most extreme environments. Despite crushing pressures, freezing temperatures, and complete darkness, a remarkable variety of organisms thrive here. Bioluminescent creatures light the void, hydrothermal vent communities sustain life through chemosynthesis, and giant squids glide through the eternal night. Scientists discover new species on almost every deep-sea expedition.",
  cat:"Nature",date:"2025-02-28",rt:"4 min",tags:["Ocean","Marine Biology","Deep Sea"]},

  {id:3,title:"Quantum Computing: Breaking the Encryption Barrier",
  content:"Quantum computers harness superposition and entanglement to perform calculations that would take classical computers millions of years in mere seconds. IBM, Google, and countless startups are racing toward quantum supremacy. The implications for cybersecurity are profound: RSA encryption could become vulnerable. Post-quantum cryptography standards are now being developed internationally to safeguard sensitive data in the coming quantum era.",
  cat:"Technology",date:"2025-01-10",rt:"6 min",tags:["Quantum","Cryptography","Computing"]},

  {id:4,title:"The Renaissance: Art, Science, and Human Potential",
  content:"The Renaissance was a cultural and intellectual movement that profoundly transformed European civilization. Beginning in Italy and spreading across the continent, it revived interest in classical philosophy, literature, and art. Leonardo da Vinci embodied the Renaissance Man ideal, excelling simultaneously in painting, sculpture, architecture, mathematics, and anatomy. Michelangelo's Sistine Chapel ceiling and The Last Judgment remain pinnacles of human artistic achievement still revered today.",
  cat:"History",date:"2024-12-05",rt:"7 min",tags:["Renaissance","Art History","Leonardo da Vinci"]},

  {id:5,title:"CRISPR Gene Editing: Rewriting the Blueprint of Life",
  content:"CRISPR-Cas9 technology represents a revolutionary leap in genetic engineering, allowing scientists to precisely edit DNA with unprecedented accuracy. Derived from a bacterial immune defense system, CRISPR enables researchers to cut, replace, or silence any gene. Clinical trials target sickle cell disease, certain cancers, and inherited blindness. The ethical implications of germline editing—changes passed to future generations—continue to spark heated global debate among scientists, ethicists, and policymakers.",
  cat:"Science",date:"2025-04-02",rt:"5 min",tags:["CRISPR","Genetics","Medicine"]},

  {id:6,title:"The Psychology of Color in Modern Design",
  content:"Color is a powerful communication tool that signals action, influences mood, and triggers physiological responses. Warm colors like red, orange, and yellow create feelings of warmth and energy. Cool blues and greens evoke calm, trust, and nature. Design systems like Google Material You and Apple Human Interface Guidelines provide detailed frameworks for color usage. Accessibility requires sufficient contrast ratios for users with color vision deficiencies, making inclusive design a core responsibility.",
  cat:"Art",date:"2025-03-22",rt:"4 min",tags:["Design","Psychology","Color Theory"]},

  {id:7,title:"Mars Colonization: Engineering Humanity's Second Home",
  content:"Mars presents extraordinary challenges for human settlement. Its atmosphere is just 1% as dense as Earth's, surface temperatures average -60°C, and there is no global magnetic field to deflect radiation. SpaceX's Starship aims to transport settlers in large numbers, while NASA's Artemis missions build foundational knowledge. In-situ resource utilization would extract water from permafrost and produce oxygen from atmospheric CO₂, turning the Martian environment into a resource rather than an obstacle.",
  cat:"Space",date:"2025-02-14",rt:"8 min",tags:["Mars","Space Exploration","Engineering"]},

  {id:8,title:"Mindfulness and the Neuroscience of Meditation",
  content:"Modern neuroscience is validating what contemplative traditions practiced for millennia. Regular meditation measurably increases prefrontal cortex thickness, responsible for executive function, while shrinking the amygdala, the brain's fear center. Eight weeks of mindfulness-based stress reduction significantly reduces anxiety, depression, and chronic pain symptoms. Brain imaging reveals increased connectivity between regions governing self-regulation, attention, and emotional processing.",
  cat:"Health",date:"2025-01-28",rt:"5 min",tags:["Mindfulness","Neuroscience","Wellness"]},

  {id:9,title:"Street Food Cultures: A World Tour of Flavors",
  content:"Street food represents the soul of any city's culinary culture, offering authentic flavors shaped by centuries of tradition, migration, and improvisation. Bangkok's night markets serve pad thai and mango sticky rice to thousands each night. Mexico City's taquerias offer tacos al pastor from vertical spits. Istanbul's simit sellers carry sesame bread rings through ancient bazaars. UNESCO's Creative Cities of Gastronomy program recognizes cities where food has become inseparable from identity.",
  cat:"Culture",date:"2025-03-10",rt:"4 min",tags:["Food","Travel","Culture"]},

  {id:10,title:"Blockchain Beyond Bitcoin: Decentralized Finance",
  content:"Blockchain technology extends far beyond cryptocurrency. Smart contracts—self-executing agreements coded on the blockchain—are transforming real estate, supply chains, and legal systems. DeFi protocols allow lending, borrowing, and trading without financial intermediaries. NFTs created entirely new economic models for digital artists. Ethereum's transition to Proof-of-Stake reduced energy consumption by over 99%, addressing one of blockchain's most significant environmental criticisms.",
  cat:"Technology",date:"2025-04-15",rt:"6 min",tags:["Blockchain","DeFi","Web3"]},

  {id:11,title:"The Amazon Rainforest: Lungs of the Earth Under Threat",
  content:"The Amazon basin covers over 5.5 million square kilometers and harbors 10% of all species on Earth, producing roughly 20% of the world's oxygen. Indigenous communities have stewarded this biodiversity for millennia, developing deep knowledge of medicinal plants and sustainable agriculture. Deforestation driven by cattle ranching and soy agriculture has destroyed over 20% of the original forest. Scientists warn the Amazon is approaching a tipping point beyond which it could irreversibly transform into savanna.",
  cat:"Nature",date:"2024-11-20",rt:"6 min",tags:["Amazon","Rainforest","Climate"]},

  {id:12,title:"The Silk Road: How Trade Shaped Civilization",
  content:"The ancient Silk Road was not a single route but a vast network connecting China to the Mediterranean world. For over 1,500 years it carried silk, spices, glassware, and precious metals. More significantly it transmitted ideas, religions, technologies, and diseases. Buddhism spread eastward into China; Islam traveled simultaneously east and west; paper-making and gunpowder moved west from China; glassblowing migrated east. The Black Death also traveled these routes devastatingly in the 14th century.",
  cat:"History",date:"2024-10-18",rt:"7 min",tags:["Silk Road","Trade","Ancient History"]},

  {id:13,title:"Sleep Science: Why Rest Is the Ultimate Superpower",
  content:"Sleep is far more than passive rest. During deep sleep, the glymphatic system flushes toxic proteins including amyloid-beta, a hallmark of Alzheimer's disease. Memory consolidation during REM sleep strengthens neural connections formed during waking hours. Chronic sleep deprivation is linked to obesity, cardiovascular disease, impaired immunity, and accelerated cognitive decline. Matthew Walker's research at UC Berkeley demonstrates that no major organ system survives sleep deprivation without measurable damage.",
  cat:"Health",date:"2025-03-30",rt:"5 min",tags:["Sleep","Neuroscience","Health"]},

  {id:14,title:"The James Webb Space Telescope: Window to the Early Universe",
  content:"The James Webb Space Telescope, launched on December 25, 2021, has fundamentally transformed our understanding of the cosmos. Orbiting at the second Lagrange point 1.5 million kilometers from Earth, its 6.5-meter gold-coated beryllium mirror captures infrared light from objects formed just 300 million years after the Big Bang. Webb has discovered surprisingly massive and mature galaxies in the early universe that challenge existing models of cosmic evolution and galaxy formation.",
  cat:"Space",date:"2025-04-10",rt:"7 min",tags:["Webb Telescope","Astronomy","Cosmology"]},

  {id:15,title:"Abstract Expressionism: Emotion on Canvas",
  content:"Abstract Expressionism emerged in New York in the 1940s and 1950s as the first major American art movement to achieve international influence. Artists like Jackson Pollock, Mark Rothko, and Willem de Kooning rejected representational form in favor of raw emotional expression. Pollock's drip technique transformed painting into an act of total bodily engagement, while Rothko's luminous color fields invite meditative contemplation. The movement fundamentally shifted the global center of contemporary art from Paris to New York.",
  cat:"Art",date:"2024-09-15",rt:"5 min",tags:["Abstract Art","Expressionism","Art History"]},

  {id:16,title:"Fermentation: The Ancient Biotechnology Feeding the Future",
  content:"Fermentation is one of humanity's oldest technologies, yet it stands at the forefront of food innovation today. For millennia, fermented foods like yogurt, kimchi, sourdough, miso, and wine have been dietary staples worldwide. Modern science reveals that fermented foods profoundly influence the gut microbiome, which in turn affects immunity, mental health, and metabolic function. Precision fermentation now allows companies to produce dairy proteins, animal fats, and heme proteins without animals, enabling sustainable food systems.",
  cat:"Science",date:"2025-02-05",rt:"5 min",tags:["Fermentation","Food Science","Microbiome"]}
];

// STATE
let query='',cat='all',sortV='def',isGrid=true;

const sInput=document.getElementById('sInput');
const sClear=document.getElementById('sClear');
const suggDrop=document.getElementById('suggDrop');
const cardsGrid=document.getElementById('cardsGrid');
const cntSpan=document.getElementById('cntSpan');
const sortSel=document.getElementById('sortSel');
const themeBtn=document.getElementById('themeBtn');
const themeIco=document.getElementById('themeIco');
const gvBtn=document.getElementById('gvBtn');
const lvBtn=document.getElementById('lvBtn');

// THEME
let dark=true;
themeBtn.addEventListener('click',()=>{
  dark=!dark;
  document.documentElement.setAttribute('data-theme',dark?'dark':'light');
  themeIco.className=dark?'fas fa-moon':'fas fa-sun';
});

// VIEW
gvBtn.addEventListener('click',()=>{
  isGrid=true;gvBtn.classList.add('on');lvBtn.classList.remove('on');
  cardsGrid.classList.remove('lv');
});
lvBtn.addEventListener('click',()=>{
  isGrid=false;lvBtn.classList.add('on');gvBtn.classList.remove('on');
  cardsGrid.classList.add('lv');
});

// SEARCH INPUT
sInput.addEventListener('input',()=>{
  query=sInput.value.trim();
  sClear.classList.toggle('show',query.length>0);
  buildSugg();
  render();
});
sInput.addEventListener('keydown',e=>{if(e.key==='Escape'){hideSugg();sInput.blur();}});
sClear.addEventListener('click',()=>{
  sInput.value='';query='';
  sClear.classList.remove('show');
  hideSugg();render();sInput.focus();
});
document.getElementById('sBtn').addEventListener('click',()=>render());
document.addEventListener('click',e=>{
  if(!e.target.closest('.search-box'))hideSugg();
});

// SUGGESTIONS
function buildSugg(){
  if(!query||query.length<2){hideSugg();return;}
  const q=query.toLowerCase();
  const hits=DATA.filter(a=>
    a.title.toLowerCase().includes(q)||
    a.tags.some(t=>t.toLowerCase().includes(q))
  ).slice(0,5);
  if(!hits.length){hideSugg();return;}
  suggDrop.innerHTML=hits.map(a=>`
    <div class="sugg-item" onclick="pickSugg(${JSON.stringify(a.title).replace(/</g,'&lt;')})">
      <i class="fas fa-file-alt"></i>
      <span>${hlText(a.title,query)}</span>
      <span class="sugg-cat">${a.cat}</span>
    </div>`).join('');
  suggDrop.classList.add('open');
}
function hideSugg(){suggDrop.classList.remove('open');}
function pickSugg(t){
  sInput.value=t;query=t;
  sClear.classList.add('show');
  hideSugg();render();
}

// FILTERS
document.querySelectorAll('.chip').forEach(c=>{
  c.addEventListener('click',()=>{
    document.querySelectorAll('.chip').forEach(x=>x.classList.remove('on'));
    c.classList.add('on');
    cat=c.dataset.cat;
    render();
  });
});

// SORT
sortSel.addEventListener('change',()=>{sortV=sortSel.value;render();});

// ESCAPE HTML
function esc(s){
  return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
          .replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}
function escRe(s){return s.replace(/[.*+?^${}()|[\]\\]/g,'\\$&');}

// HIGHLIGHT
function hlText(text,q){
  if(!q||!q.trim())return esc(text);
  const escaped=esc(text);
  const re=new RegExp(`(${escRe(esc(q))})`,`gi`);
  return escaped.replace(re,'<mark class="hl">$1</mark>');
}

// COUNT MATCHES
function countM(text,q){
  if(!q)return 0;
  const m=text.toLowerCase().match(new RegExp(escRe(q.toLowerCase()),'g'));
  return m?m.length:0;
}

// CATEGORY STYLE
const catMap={
  Technology:{cls:'ct',ico:'🖥'},
  Nature:{cls:'cn',ico:'🌿'},
  Science:{cls:'cs',ico:'🔬'},
  History:{cls:'ch',ico:'📜'},
  Art:{cls:'ca',ico:'🎨'},
  Health:{cls:'chl',ico:'❤️'},
  Space:{cls:'csp',ico:'🚀'},
  Culture:{cls:'ccu',ico:'🌍'}
};

// FORMAT DATE
function fmtDate(d){
  return new Date(d).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
}

// RENDER
function render(){
  // filter
  let list=DATA.filter(a=>{
    if(cat!=='all'&&a.cat!==cat)return false;
    if(!query)return true;
    const q=query.toLowerCase();
    return a.title.toLowerCase().includes(q)||
           a.content.toLowerCase().includes(q)||
           a.tags.some(t=>t.toLowerCase().includes(q))||
           a.cat.toLowerCase().includes(q);
  });
  // sort
  if(sortV==='ta')list.sort((a,b)=>a.title.localeCompare(b.title));
  else if(sortV==='td')list.sort((a,b)=>b.title.localeCompare(a.title));
  else if(sortV==='dn')list.sort((a,b)=>new Date(b.date)-new Date(a.date));
  else if(sortV==='do')list.sort((a,b)=>new Date(a.date)-new Date(b.date));

  cntSpan.textContent=list.length;

  if(!list.length){
    cardsGrid.innerHTML=`
      <div class="empty">
        <div class="empty-ico">🔍</div>
        <div class="empty-t">No results found</div>
        <div class="empty-s">Try different keywords or remove category filters</div>
      </div>`;
    return;
  }

  cardsGrid.innerHTML=list.map((a,i)=>{
    const m=catMap[a.cat]||{cls:'ct',ico:'📄'};
    const totalM=query?countM(a.title+' '+a.content+' '+a.tags.join(' '),query):0;
    const mBadge=totalM>0
      ?`<span class="mbadge"><i class="fas fa-highlighter" style="font-size:8px;"></i> ${totalM}</span>`
      :'';
    return `
    <article class="card" style="animation-delay:${i*0.055}s;" aria-label="${esc(a.title)}">
      <div class="card-top">
        <span class="c-cat ${m.cls}">${m.ico} ${a.cat}</span>
        <div class="c-meta">
          ${mBadge}
          <span><i class="fas fa-clock" style="font-size:9px;margin-right:2px;"></i>${a.rt}</span>
        </div>
      </div>
      <div class="card-body">
        <h2 class="card-title">${hlText(a.title,query)}</h2>
        <p class="card-content">${hlText(a.content,query)}</p>
      </div>
      <div class="card-footer">
        <div class="c-tags">${a.tags.slice(0,3).map(t=>`<span class="c-tag">${hlText(t,query)}</span>`).join('')}</div>
        <span class="read-more">Read more <i class="fas fa-arrow-right" style="font-size:9px;"></i></span>
      </div>
      <div class="card-date">
        <i class="fas fa-calendar-alt" style="font-size:9px;"></i> ${fmtDate(a.date)}
      </div>
    </article>`;
  }).join('');
}

// INIT
render();
</script>
</body>
</html>
