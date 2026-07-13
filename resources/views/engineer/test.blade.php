<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NEXUS-7 // COMMAND INTERFACE v4.2</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Orbitron:wght@400;500;600;700;900&family=Exo+2:wght@300;400;500&display=swap" rel="stylesheet"/>

  <style>
    :root {
      --cyan:   #00f0ff;
      --green:  #00ff41;
      --amber:  #ffaa00;
      --red:    #ff003c;
      --purple: #a855f7;
      --bg:     #020609;
      --bg2:    #050d14;
      --bg3:    #071525;
      --panel:  rgba(0,240,255,0.03);
      --border: rgba(0,240,255,0.18);
      --border2:rgba(0,240,255,0.08);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Share Tech Mono', monospace;
      background: var(--bg);
      color: var(--cyan);
      min-height: 100vh;
      overflow-x: hidden;
      position: relative;
    }

    /* ── SCAN LINE OVERLAY ── */
    body::before {
      content: '';
      position: fixed; inset: 0;
      background: repeating-linear-gradient(
        0deg,
        transparent,
        transparent 2px,
        rgba(0,0,0,0.08) 2px,
        rgba(0,0,0,0.08) 4px
      );
      pointer-events: none;
      z-index: 9999;
    }

    /* ── VIGNETTE ── */
    body::after {
      content: '';
      position: fixed; inset: 0;
      background: radial-gradient(ellipse at center, transparent 50%, rgba(0,0,0,0.7) 100%);
      pointer-events: none;
      z-index: 9998;
    }

    /* ── NOISE GRAIN ── */
    .noise {
      position: fixed; inset: 0;
      opacity: 0.025;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 9997;
    }

    /* ── FONTS ── */
    .font-orb  { font-family: 'Orbitron', sans-serif; }
    .font-mono { font-family: 'Share Tech Mono', monospace; }
    .font-exo  { font-family: 'Exo 2', sans-serif; }

    /* ── GLOW UTILITIES ── */
    .glow-c  { text-shadow: 0 0 8px var(--cyan),  0 0 24px rgba(0,240,255,0.4); }
    .glow-g  { text-shadow: 0 0 8px var(--green), 0 0 24px rgba(0,255,65,0.4); }
    .glow-a  { text-shadow: 0 0 8px var(--amber), 0 0 24px rgba(255,170,0,0.4); }
    .glow-r  { text-shadow: 0 0 8px var(--red),   0 0 24px rgba(255,0,60,0.4); }

    .border-glow { box-shadow: 0 0 12px rgba(0,240,255,0.12), inset 0 0 12px rgba(0,240,255,0.03); }
    .border-glow-r { box-shadow: 0 0 16px rgba(255,0,60,0.2), inset 0 0 8px rgba(255,0,60,0.05); }

    /* ── PANEL BASE ── */
    .panel {
      background: var(--panel);
      border: 1px solid var(--border);
      position: relative;
    }

    .panel::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(0,240,255,0.04) 0%, transparent 50%);
      pointer-events: none;
    }

    /* ── CLIP SHAPES ── */
    .clip-tl { clip-path: polygon(16px 0%, 100% 0%, 100% 100%, 0% 100%, 0% 16px); }
    .clip-tr { clip-path: polygon(0% 0%, calc(100% - 16px) 0%, 100% 16px, 100% 100%, 0% 100%); }
    .clip-br { clip-path: polygon(0% 0%, 100% 0%, 100% calc(100% - 16px), calc(100% - 16px) 100%, 0% 100%); }
    .clip-bl { clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 16px 100%, 0% calc(100% - 16px)); }
    .clip-all { clip-path: polygon(16px 0%, calc(100% - 16px) 0%, 100% 16px, 100% calc(100% - 16px), calc(100% - 16px) 100%, 16px 100%, 0% calc(100% - 16px), 0% 16px); }
    .clip-sm  { clip-path: polygon(8px 0%, calc(100% - 8px) 0%, 100% 8px, 100% calc(100% - 8px), calc(100% - 8px) 100%, 8px 100%, 0% calc(100% - 8px), 0% 8px); }

    /* ── LABEL ── */
    .sys-label {
      font-family: 'Orbitron', sans-serif;
      font-size: 8px;
      letter-spacing: 0.22em;
      color: rgba(0,240,255,0.45);
      text-transform: uppercase;
      padding: 4px 8px;
      border-bottom: 1px solid var(--border2);
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .sys-label::before {
      content: '◈';
      font-size: 7px;
      color: var(--cyan);
      opacity: 0.6;
    }

    /* ── PULSE DOT ── */
    .pulse-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--green);
      box-shadow: 0 0 6px var(--green);
      animation: pulse-anim 2s infinite;
      flex-shrink: 0;
    }

    .pulse-dot.amber { background: var(--amber); box-shadow: 0 0 6px var(--amber); }
    .pulse-dot.red   { background: var(--red);   box-shadow: 0 0 6px var(--red); animation: pulse-anim 0.6s infinite; }

    @keyframes pulse-anim {
      0%, 100% { opacity: 1; transform: scale(1); }
      50%       { opacity: 0.4; transform: scale(0.8); }
    }

    /* ── BLINK ── */
    .blink { animation: blink 1.2s step-end infinite; }
    @keyframes blink { 0%,100%{ opacity:1; } 50%{ opacity:0; } }

    /* ── GLITCH ── */
    .glitch {
      position: relative;
      animation: glitch-main 4s infinite;
    }

    @keyframes glitch-main {
      0%,94%,100% { transform: none; }
      95%  { transform: skewX(-1deg) translateX(2px); filter: hue-rotate(20deg); }
      97%  { transform: skewX(0.5deg) translateX(-1px); }
    }

    /* ── SCAN LINE SWEEP ── */
    .scan-sweep {
      position: relative;
      overflow: hidden;
    }

    .scan-sweep::after {
      content: '';
      position: absolute;
      left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--cyan), transparent);
      animation: sweep 3s linear infinite;
      opacity: 0.5;
    }

    @keyframes sweep {
      0%   { top: 0; }
      100% { top: 100%; }
    }

    /* ── BAR FILL ANIMATION ── */
    .bar-fill {
      height: 100%;
      border-radius: 1px;
      position: relative;
      transition: width 1s ease;
      overflow: hidden;
    }

    .bar-fill::after {
      content: '';
      position: absolute;
      top: 0; right: 0; bottom: 0;
      width: 4px;
      background: white;
      opacity: 0.6;
      box-shadow: 0 0 6px currentColor;
      animation: bar-flicker 2s infinite;
    }

    @keyframes bar-flicker {
      0%,100% { opacity: 0.6; }
      50%      { opacity: 1; }
    }

    /* ── TICKER ── */
    .ticker-wrap { overflow: hidden; white-space: nowrap; }
    .ticker-inner { display: inline-block; animation: ticker 28s linear infinite; }
    @keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

    /* ── HEX GRID BACKGROUND ── */
    .hex-bg {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='100'%3E%3Cpath d='M28 66L0 50V17L28 1l28 16v33L28 66zM28 100L0 84V51l28-16 28 16v33L28 100z' fill='none' stroke='rgba(0,240,255,0.04)' stroke-width='1'/%3E%3C/svg%3E");
    }

    /* ── CORNER DECORATIONS ── */
    .corner-tl::before, .corner-tl::after,
    .corner-br::before, .corner-br::after {
      content: '';
      position: absolute;
      width: 12px; height: 12px;
    }

    .corner-tl::before {
      top: 0; left: 0;
      border-top: 1.5px solid var(--cyan);
      border-left: 1.5px solid var(--cyan);
      box-shadow: -1px -1px 6px rgba(0,240,255,0.3);
    }

    .corner-tl::after {
      bottom: 0; right: 0;
      border-bottom: 1.5px solid var(--cyan);
      border-right: 1.5px solid var(--cyan);
      box-shadow: 1px 1px 6px rgba(0,240,255,0.3);
    }

    /* ── WAVEFORM ── */
    .wave-bar {
      width: 3px;
      background: var(--cyan);
      border-radius: 1px;
      box-shadow: 0 0 4px var(--cyan);
      animation: wave 1s ease-in-out infinite alternate;
    }

    @keyframes wave {
      0%   { transform: scaleY(0.2); }
      100% { transform: scaleY(1); }
    }

    /* ── SCROLLBAR ── */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-track { background: var(--bg2); }
    ::-webkit-scrollbar-thumb { background: rgba(0,240,255,0.3); border-radius: 2px; }

    /* ── RING SPINNER ── */
    .ring-spin {
      border: 1.5px solid rgba(0,240,255,0.15);
      border-top-color: var(--cyan);
      border-radius: 50%;
      animation: spin 1.4s linear infinite;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── DATA STREAM ── */
    .data-stream {
      font-size: 9px;
      color: rgba(0,255,65,0.35);
      line-height: 1.6;
      overflow: hidden;
      max-height: 60px;
    }

    /* ── ALERT FLASH ── */
    @keyframes alert-flash {
      0%,100% { background: rgba(255,0,60,0.04); }
      50%      { background: rgba(255,0,60,0.12); }
    }

    .alert-pulse { animation: alert-flash 1s infinite; }

    /* ── STATUS BADGE ── */
    .status-badge {
      font-family: 'Orbitron', sans-serif;
      font-size: 7px;
      letter-spacing: 0.15em;
      padding: 2px 8px;
      clip-path: polygon(6px 0%, calc(100% - 6px) 0%, 100% 50%, calc(100% - 6px) 100%, 6px 100%, 0% 50%);
    }

    /* ── MATRIX RAIN CANVAS ── */
    #matrixCanvas {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      opacity: 0.04;
      pointer-events: none;
      z-index: 1;
    }

    /* ── LAYOUT WRAPPER ── */
    .hud-root {
      position: relative;
      z-index: 10;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      gap: 6px;
      padding: 8px;
    }

    /* ── TOP HUD BAR ── */
    .hud-topbar {
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      align-items: center;
      gap: 8px;
      padding: 6px 12px;
      border: 1px solid var(--border);
      border-bottom: 1px solid rgba(0,240,255,0.25);
      background: rgba(0,240,255,0.02);
      clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 20px, 100% 100%, 20px 100%, 0 calc(100% - 20px));
      position: relative;
    }

    /* ── MAIN GRID ── */
    .hud-main {
      display: grid;
      grid-template-columns: 280px 1fr 280px;
      gap: 6px;
      flex: 1;
    }

    .hud-left, .hud-right {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .hud-center {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    /* ── BOTTOM TICKER ── */
    .hud-bottom {
      border: 1px solid var(--border);
      padding: 5px 12px;
      display: flex;
      align-items: center;
      gap: 12px;
      background: rgba(0,240,255,0.02);
      font-size: 10px;
    }
  </style>
</head>

<body>

<canvas id="matrixCanvas"></canvas>
<div class="noise"></div>

<div class="hud-root">

  <!-- ══════════════════════════════════════════
       TOP COMMAND BAR
  ══════════════════════════════════════════ -->
  <header class="hud-topbar border-glow">

    <!-- LEFT: Ship ID + Status -->
    <div class="flex items-center gap-4">
      <div class="flex items-center gap-2">
        <div class="pulse-dot"></div>
        <span class="font-orb text-[9px] tracking-[0.25em] text-cyan-400/60">VESSEL</span>
        <span class="font-orb text-[11px] tracking-[0.2em] glow-c" style="color:var(--cyan)">UES NEXUS-7</span>
      </div>
      <div class="w-px h-5" style="background:var(--border)"></div>
      <div class="text-[9px] text-cyan-400/40 font-mono">HULL CLASS: <span class="text-cyan-300/70">VANGUARD-IV</span></div>
      <div class="w-px h-5" style="background:var(--border)"></div>
      <div class="text-[9px] text-cyan-400/40 font-mono">SECTOR: <span style="color:var(--amber)" class="glow-a">ORION-7 EXPANSE</span></div>
    </div>

    <!-- CENTER: Main title -->
    <div class="text-center">
      <div class="font-orb text-[20px] font-black tracking-[0.35em] glitch glow-c" style="color:var(--cyan); letter-spacing:0.3em">
        NEXUS<span style="color:rgba(0,240,255,0.35)">://</span>CMD
      </div>
      <div class="font-mono text-[8px] tracking-[0.4em] text-cyan-400/40 mt-0.5">ADVANCED AI OPERATIONS CENTER v4.2.1</div>
    </div>

    <!-- RIGHT: Time + Alert -->
    <div class="flex items-center justify-end gap-4">
      <div class="text-right">
        <div id="stardate" class="font-mono text-[11px]" style="color:var(--cyan)">SD 2749.183</div>
        <div id="clock" class="font-mono text-[9px] text-cyan-400/50">00:00:00 UTC</div>
      </div>
      <div class="w-px h-5" style="background:var(--border)"></div>
      <div class="flex items-center gap-2">
        <div class="pulse-dot amber"></div>
        <div>
          <div class="font-orb text-[7px] tracking-[0.2em] text-amber-400/60">ALERT LVL</div>
          <div class="font-orb text-[13px] font-bold glow-a" style="color:var(--amber)">YELLOW</div>
        </div>
      </div>
      <div class="status-badge" style="background:rgba(255,170,0,0.15); color:var(--amber); border:1px solid rgba(255,170,0,0.3)">STANDBY</div>
    </div>
  </header>

  <!-- ══════════════════════════════════════════
       MAIN HUD GRID
  ══════════════════════════════════════════ -->
  <div class="hud-main">

    <!-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
         LEFT COLUMN
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ -->
    <div class="hud-left">

      <!-- SHIP SYSTEMS STATUS -->
      <div class="panel clip-tl border-glow flex-1" style="min-height:180px">
        <div class="sys-label">SHIP SYSTEMS INTEGRITY</div>
        <div class="p-3 space-y-2.5">

          <!-- Each system bar -->
          <div>
            <div class="flex justify-between text-[10px] mb-1">
              <span class="text-cyan-400/60">HULL PLATING</span>
              <span class="font-mono" style="color:var(--green)" id="hull-val">94%</span>
            </div>
            <div class="h-1.5 rounded-none" style="background:rgba(0,240,255,0.08); clip-path: polygon(4px 0%, 100% 0%, calc(100% - 4px) 100%, 0% 100%)">
              <div class="bar-fill" style="width:94%; background:linear-gradient(90deg, rgba(0,255,65,0.6), var(--green)); box-shadow:0 0 8px var(--green)"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between text-[10px] mb-1">
              <span class="text-cyan-400/60">DEFLECTOR SHIELD</span>
              <span class="font-mono" style="color:var(--cyan)" id="shield-val">71%</span>
            </div>
            <div class="h-1.5" style="background:rgba(0,240,255,0.08); clip-path: polygon(4px 0%, 100% 0%, calc(100% - 4px) 100%, 0% 100%)">
              <div class="bar-fill" style="width:71%; background:linear-gradient(90deg, rgba(0,200,255,0.6), var(--cyan)); box-shadow:0 0 8px var(--cyan)"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between text-[10px] mb-1">
              <span class="text-cyan-400/60">WARP CORE OUTPUT</span>
              <span class="font-mono" style="color:var(--amber)">88%</span>
            </div>
            <div class="h-1.5" style="background:rgba(0,240,255,0.08); clip-path: polygon(4px 0%, 100% 0%, calc(100% - 4px) 100%, 0% 100%)">
              <div class="bar-fill" style="width:88%; background:linear-gradient(90deg, rgba(255,140,0,0.6), var(--amber)); box-shadow:0 0 8px var(--amber)"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between text-[10px] mb-1">
              <span class="text-cyan-400/60">LIFE SUPPORT</span>
              <span class="font-mono" style="color:var(--green)">100%</span>
            </div>
            <div class="h-1.5" style="background:rgba(0,240,255,0.08); clip-path: polygon(4px 0%, 100% 0%, calc(100% - 4px) 100%, 0% 100%)">
              <div class="bar-fill" style="width:100%; background:linear-gradient(90deg, rgba(0,255,65,0.6), var(--green)); box-shadow:0 0 8px var(--green)"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between text-[10px] mb-1">
              <span class="text-cyan-400/60">WEAPONS ARRAY</span>
              <span class="font-mono" style="color:var(--red)">43%</span>
            </div>
            <div class="h-1.5" style="background:rgba(0,240,255,0.08); clip-path: polygon(4px 0%, 100% 0%, calc(100% - 4px) 100%, 0% 100%)">
              <div class="bar-fill" style="width:43%; background:linear-gradient(90deg, rgba(255,0,60,0.6), var(--red)); box-shadow:0 0 8px var(--red)"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between text-[10px] mb-1">
              <span class="text-cyan-400/60">NAVIGATION AI</span>
              <span class="font-mono" style="color:var(--cyan)">99%</span>
            </div>
            <div class="h-1.5" style="background:rgba(0,240,255,0.08); clip-path: polygon(4px 0%, 100% 0%, calc(100% - 4px) 100%, 0% 100%)">
              <div class="bar-fill" style="width:99%; background:linear-gradient(90deg, rgba(0,200,255,0.6), var(--cyan)); box-shadow:0 0 8px var(--cyan)"></div>
            </div>
          </div>

        </div>
      </div>

      <!-- POWER DISTRIBUTION -->
      <div class="panel clip-all" style="min-height:140px">
        <div class="sys-label">POWER DISTRIBUTION NODE</div>
        <div class="p-3">
          <div class="grid grid-cols-3 gap-2 text-center">
            <div>
              <div class="text-[8px] text-cyan-400/40 mb-1.5 font-orb tracking-wider">PROPULSION</div>
              <div class="relative mx-auto" style="width:48px;height:48px">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full -rotate-90">
                  <circle cx="24" cy="24" r="20" stroke="rgba(0,240,255,0.1)" stroke-width="4"/>
                  <circle cx="24" cy="24" r="20" stroke="var(--cyan)" stroke-width="4" stroke-dasharray="125.6" stroke-dashoffset="22" stroke-linecap="round" style="filter:drop-shadow(0 0 4px var(--cyan))"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center font-orb text-[10px] font-bold" style="color:var(--cyan)">82%</div>
              </div>
              <div class="text-[8px] text-cyan-400/40 mt-1">4.2 GW</div>
            </div>
            <div>
              <div class="text-[8px] text-cyan-400/40 mb-1.5 font-orb tracking-wider">WEAPONS</div>
              <div class="relative mx-auto" style="width:48px;height:48px">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full -rotate-90">
                  <circle cx="24" cy="24" r="20" stroke="rgba(255,0,60,0.1)" stroke-width="4"/>
                  <circle cx="24" cy="24" r="20" stroke="var(--red)" stroke-width="4" stroke-dasharray="125.6" stroke-dashoffset="75" stroke-linecap="round" style="filter:drop-shadow(0 0 4px var(--red))"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center font-orb text-[10px] font-bold" style="color:var(--red)">40%</div>
              </div>
              <div class="text-[8px] text-red-400/40 mt-1">2.0 GW</div>
            </div>
            <div>
              <div class="text-[8px] text-cyan-400/40 mb-1.5 font-orb tracking-wider">SHIELDS</div>
              <div class="relative mx-auto" style="width:48px;height:48px">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full -rotate-90">
                  <circle cx="24" cy="24" r="20" stroke="rgba(255,170,0,0.1)" stroke-width="4"/>
                  <circle cx="24" cy="24" r="20" stroke="var(--amber)" stroke-width="4" stroke-dasharray="125.6" stroke-dashoffset="38" stroke-linecap="round" style="filter:drop-shadow(0 0 4px var(--amber))"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center font-orb text-[10px] font-bold" style="color:var(--amber)">70%</div>
              </div>
              <div class="text-[8px] text-amber-400/40 mt-1">3.5 GW</div>
            </div>
          </div>
        </div>
      </div>

      <!-- CREW STATUS -->
      <div class="panel clip-br" style="min-height:110px">
        <div class="sys-label">CREW MANIFEST · ACTIVE STATIONS</div>
        <div class="p-2.5 space-y-1.5">
          <div class="flex items-center justify-between text-[10px]">
            <div class="flex items-center gap-2"><div class="pulse-dot" style="width:5px;height:5px"></div><span class="text-cyan-400/60">CMD BRIDGE</span></div>
            <span style="color:var(--green)">8 / 8</span>
          </div>
          <div class="flex items-center justify-between text-[10px]">
            <div class="flex items-center gap-2"><div class="pulse-dot" style="width:5px;height:5px"></div><span class="text-cyan-400/60">ENGINEERING</span></div>
            <span style="color:var(--green)">12 / 12</span>
          </div>
          <div class="flex items-center justify-between text-[10px]">
            <div class="flex items-center gap-2"><div class="pulse-dot amber" style="width:5px;height:5px"></div><span class="text-cyan-400/60">TACTICAL</span></div>
            <span style="color:var(--amber)">4 / 6</span>
          </div>
          <div class="flex items-center justify-between text-[10px]">
            <div class="flex items-center gap-2"><div class="pulse-dot red" style="width:5px;height:5px"></div><span class="text-cyan-400/60">ARMORY</span></div>
            <span style="color:var(--red)">1 / 4</span>
          </div>
          <div class="flex items-center justify-between text-[10px]">
            <div class="flex items-center gap-2"><div class="pulse-dot" style="width:5px;height:5px"></div><span class="text-cyan-400/60">MED BAY</span></div>
            <span style="color:var(--green)">3 / 3</span>
          </div>
        </div>
      </div>

    </div><!-- /hud-left -->

    <!-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
         CENTER COLUMN
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ -->
    <div class="hud-center">

      <!-- TACTICAL SCANNER -->
      <div class="panel border-glow flex-1 relative" style="background: var(--panel); min-height: 320px;">
        <div class="sys-label">LONG-RANGE TACTICAL SCANNER · SECTOR ORION-7</div>
        <div class="relative w-full" style="height: calc(100% - 26px)">
          <canvas id="radarCanvas" style="width:100%;height:100%;display:block;"></canvas>
          <!-- RADAR OVERLAYS -->
          <div class="absolute top-2 left-2 text-[8px] font-mono" style="color:rgba(0,240,255,0.4)">
            RANGE: <span style="color:var(--cyan)">12,000 km</span>
          </div>
          <div class="absolute top-2 right-2 text-[8px] font-mono flex items-center gap-1.5" style="color:rgba(0,240,255,0.4)">
            <div class="ring-spin" style="width:10px;height:10px"></div>
            SCANNING
          </div>
          <div class="absolute bottom-2 left-2 text-[8px] font-mono space-y-0.5">
            <div style="color:rgba(0,255,65,0.6)">● FRIENDLY (3)</div>
            <div style="color:rgba(255,170,0,0.6)">● NEUTRAL (7)</div>
            <div style="color:rgba(255,0,60,0.6)">● HOSTILE (2)</div>
          </div>
          <div class="absolute bottom-2 right-2 text-right text-[8px] font-mono">
            <div style="color:rgba(0,240,255,0.4)">COORD</div>
            <div style="color:var(--cyan)" class="font-mono">X: +4821.3</div>
            <div style="color:var(--cyan)" class="font-mono">Y: −0934.7</div>
          </div>
        </div>
      </div>

      <!-- SENSOR TELEMETRY CHART -->
      <div class="panel clip-tl" style="height:160px">
        <div class="sys-label">REAL-TIME SENSOR TELEMETRY · QUANTUM FLUX READINGS</div>
        <div class="px-3 pb-2" style="height:calc(100% - 26px)">
          <canvas id="telemetryChart" style="width:100%;height:100%;"></canvas>
        </div>
      </div>

      <!-- MISSION LOG + COMMS -->
      <div class="grid grid-cols-2 gap-1.5" style="height:150px">

        <div class="panel clip-bl">
          <div class="sys-label">MISSION OBJECTIVES</div>
          <div class="p-2.5 space-y-1.5 overflow-y-auto" style="max-height:115px">
            <div class="flex items-start gap-2 text-[10px]">
              <span style="color:var(--green)" class="mt-0.5 font-orb text-[8px]">✓</span>
              <span class="text-cyan-400/50 line-through">Jump to Orion-7 sector</span>
            </div>
            <div class="flex items-start gap-2 text-[10px]">
              <span style="color:var(--green)" class="mt-0.5 font-orb text-[8px]">✓</span>
              <span class="text-cyan-400/50 line-through">Deploy probe array</span>
            </div>
            <div class="flex items-start gap-2 text-[10px]">
              <span style="color:var(--amber)" class="mt-0.5 font-orb text-[8px] blink">▶</span>
              <span style="color:var(--amber)">Scan anomaly at grid 7-C</span>
            </div>
            <div class="flex items-start gap-2 text-[10px]">
              <span class="text-cyan-400/25 mt-0.5 font-orb text-[8px]">○</span>
              <span class="text-cyan-400/35">Rendezvous Starbase 19</span>
            </div>
            <div class="flex items-start gap-2 text-[10px]">
              <span class="text-cyan-400/25 mt-0.5 font-orb text-[8px]">○</span>
              <span class="text-cyan-400/35">Submit sector report</span>
            </div>
          </div>
        </div>

        <div class="panel clip-br alert-pulse" style="border-color:rgba(255,0,60,0.3)">
          <div class="sys-label" style="color:rgba(255,0,60,0.5); border-color:rgba(255,0,60,0.15)">⚠ ACTIVE ALERTS · 2 CRITICAL</div>
          <div class="p-2.5 space-y-2">
            <div class="p-1.5 text-[10px]" style="border:1px solid rgba(255,0,60,0.2); background:rgba(255,0,60,0.05)">
              <div class="font-orb text-[8px] tracking-wider" style="color:var(--red)">CRITICAL</div>
              <div class="text-cyan-300/70 mt-0.5">Weapons array offline · Grid 4</div>
            </div>
            <div class="p-1.5 text-[10px]" style="border:1px solid rgba(255,170,0,0.2); background:rgba(255,170,0,0.04)">
              <div class="font-orb text-[8px] tracking-wider" style="color:var(--amber)">WARNING</div>
              <div class="text-cyan-300/70 mt-0.5">Unknown vessel — 8,400 km</div>
            </div>
          </div>
        </div>

      </div>

    </div><!-- /hud-center -->

    <!-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
         RIGHT COLUMN
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ -->
    <div class="hud-right">

      <!-- AI CORE STATUS -->
      <div class="panel clip-tr border-glow" style="min-height:130px">
        <div class="sys-label">NEXUS AI CORE · NEURAL NET STATUS</div>
        <div class="p-3 flex gap-3 items-center">
          <!-- Hex AI orb -->
          <div class="relative flex-shrink-0" style="width:72px;height:72px">
            <svg viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full" style="animation: spin 8s linear infinite reverse">
              <polygon points="36,4 64,20 64,52 36,68 8,52 8,20" stroke="rgba(0,240,255,0.15)" stroke-width="1" fill="none"/>
              <polygon points="36,10 58,23 58,49 36,62 14,49 14,23" stroke="rgba(0,240,255,0.25)" stroke-width="1" fill="none"/>
            </svg>
            <svg viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full absolute inset-0" style="animation: spin 3s linear infinite">
              <polygon points="36,14 54,24.5 54,47.5 36,58 18,47.5 18,24.5" stroke="rgba(0,240,255,0.4)" stroke-width="1.5" fill="rgba(0,240,255,0.03)"/>
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="font-orb text-[9px] font-bold glow-c" style="color:var(--cyan)">AI<br><span style="font-size:7px;color:rgba(0,240,255,0.5)">NEXUS</span></div>
            </div>
          </div>
          <div class="flex-1 space-y-2">
            <div>
              <div class="flex justify-between text-[9px] mb-1"><span class="text-cyan-400/50">COGNITION</span><span style="color:var(--green)">98.7%</span></div>
              <div class="h-1" style="background:rgba(0,255,65,0.08)"><div class="h-full" style="width:98.7%; background:var(--green); box-shadow:0 0 6px var(--green)"></div></div>
            </div>
            <div>
              <div class="flex justify-between text-[9px] mb-1"><span class="text-cyan-400/50">THREAT EVAL</span><span style="color:var(--amber)">77.2%</span></div>
              <div class="h-1" style="background:rgba(255,170,0,0.08)"><div class="h-full" style="width:77.2%; background:var(--amber); box-shadow:0 0 6px var(--amber)"></div></div>
            </div>
            <div>
              <div class="flex justify-between text-[9px] mb-1"><span class="text-cyan-400/50">COMMS RELAY</span><span style="color:var(--cyan)">100%</span></div>
              <div class="h-1" style="background:rgba(0,240,255,0.08)"><div class="h-full" style="width:100%; background:var(--cyan); box-shadow:0 0 6px var(--cyan)"></div></div>
            </div>
            <div class="text-[8px] font-mono mt-1" style="color:rgba(0,255,65,0.5)">
              <span class="blink">_</span> NEXUS AI NOMINAL · ALL SUBSYSTEMS ONLINE
            </div>
          </div>
        </div>
      </div>

      <!-- CONTACT ANALYSIS -->
      <div class="panel clip-all" style="min-height:160px">
        <div class="sys-label">CONTACT ANALYSIS · IDENTIFIED VESSELS</div>
        <div class="p-2.5 space-y-1.5">

          <div class="p-2 text-[9px]" style="border:1px solid rgba(0,255,65,0.2); background:rgba(0,255,65,0.03)">
            <div class="flex justify-between mb-0.5">
              <span class="font-orb text-[8px]" style="color:var(--green)">FRIENDLY // UES CARDINAL</span>
              <span style="color:rgba(0,255,65,0.5)">4,200 km</span>
            </div>
            <div class="text-cyan-400/40">Class: Sentinel-III · HEADING 224°</div>
            <div class="text-cyan-400/30 font-mono">IFF VERIFIED · COMM ACTIVE</div>
          </div>

          <div class="p-2 text-[9px]" style="border:1px solid rgba(255,170,0,0.2); background:rgba(255,170,0,0.03)">
            <div class="flex justify-between mb-0.5">
              <span class="font-orb text-[8px]" style="color:var(--amber)">UNKNOWN // VESSEL-Δ4</span>
              <span style="color:rgba(255,170,0,0.5)">8,400 km</span>
            </div>
            <div class="text-cyan-400/40">Class: Unclassified · HEADING 091°</div>
            <div style="color:var(--amber)" class="font-mono">NO IFF · ANALYZING...</div>
          </div>

          <div class="p-2 text-[9px]" style="border:1px solid rgba(255,0,60,0.2); background:rgba(255,0,60,0.04)">
            <div class="flex justify-between mb-0.5">
              <span class="font-orb text-[8px]" style="color:var(--red)">HOSTILE // VORATH-CLASS</span>
              <span style="color:rgba(255,0,60,0.5)">11,800 km</span>
            </div>
            <div class="text-cyan-400/40">Class: Warbird-IX · HEADING 347°</div>
            <div style="color:var(--red)" class="font-mono blink">WEAPONS HOT · THREAT LVL 9</div>
          </div>

        </div>
      </div>

      <!-- COMMS CHANNEL -->
      <div class="panel clip-tl" style="min-height:120px">
        <div class="sys-label">ENCRYPTED COMMS · CHANNEL 7-ALPHA</div>
        <div class="p-2.5">
          <div class="space-y-2">
            <div class="text-[9px]">
              <span class="font-orb text-[8px]" style="color:var(--cyan)">STARBASE-19 // 14:32</span>
              <p class="text-cyan-400/50 mt-0.5">Rendezvous confirmed. ETA adjusted to SD 2749.21.</p>
            </div>
            <div style="border-top:1px solid var(--border2)" class="pt-2 text-[9px]">
              <span class="font-orb text-[8px]" style="color:var(--green)">ADMIRAL-CROSS // 14:41</span>
              <p class="text-cyan-400/50 mt-0.5">Investigate grid 7-C anomaly before docking. Priority ALPHA.</p>
            </div>
            <div style="border-top:1px solid var(--border2)" class="pt-2 text-[9px]">
              <span class="font-orb text-[8px] blink" style="color:rgba(0,240,255,0.4)">INCOMING TRANSMISSION...</span>
            </div>
          </div>
        </div>
      </div>

      <!-- WAVEFORM / AUDIO SIGNAL -->
      <div class="panel clip-br flex-1">
        <div class="sys-label">SIGNAL INTELLIGENCE · SUBSPACE FREQ ANALYSIS</div>
        <div class="p-3">
          <div class="flex items-end gap-[3px]" style="height:50px">
            <div class="wave-bar" style="height:60%; animation-delay:0s;    background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:80%; animation-delay:.07s;  background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:40%; animation-delay:.14s;  background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:100%;animation-delay:.21s;  background:var(--amber);  box-shadow:0 0 4px var(--amber)"></div>
            <div class="wave-bar" style="height:70%; animation-delay:.28s;  background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:55%; animation-delay:.35s;  background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:90%; animation-delay:.42s;  background:var(--red);    box-shadow:0 0 4px var(--red)"></div>
            <div class="wave-bar" style="height:65%; animation-delay:.49s;  background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:45%; animation-delay:.56s;  background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:80%; animation-delay:.63s;  background:var(--green);  box-shadow:0 0 4px var(--green)"></div>
            <div class="wave-bar" style="height:60%; animation-delay:.70s;  background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:35%; animation-delay:.77s;  background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:75%; animation-delay:.84s;  background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:50%; animation-delay:.91s;  background:var(--amber);  box-shadow:0 0 4px var(--amber)"></div>
            <div class="wave-bar" style="height:85%; animation-delay:.98s;  background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:40%; animation-delay:1.05s; background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:70%; animation-delay:1.12s; background:var(--green);  box-shadow:0 0 4px var(--green)"></div>
            <div class="wave-bar" style="height:95%; animation-delay:1.19s; background:var(--red);    box-shadow:0 0 4px var(--red)"></div>
            <div class="wave-bar" style="height:55%; animation-delay:1.26s; background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:65%; animation-delay:1.33s; background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:30%; animation-delay:1.40s; background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:78%; animation-delay:1.47s; background:var(--amber);  box-shadow:0 0 4px var(--amber)"></div>
            <div class="wave-bar" style="height:62%; animation-delay:1.54s; background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
            <div class="wave-bar" style="height:48%; animation-delay:1.61s; background:var(--cyan);   box-shadow:0 0 4px var(--cyan)"></div>
          </div>
          <div class="mt-2 flex justify-between text-[8px] font-mono">
            <span style="color:rgba(0,240,255,0.35)">FREQ: 2.4 THz</span>
            <span style="color:rgba(255,170,0,0.6)" class="blink">ANOMALOUS SIGNAL DETECTED</span>
            <span style="color:rgba(0,240,255,0.35)">ENCRYPT: AES-2048</span>
          </div>
          <!-- Data stream -->
          <div class="data-stream mt-2" id="dataStream">
            10110010 11001010 00110101 11010010 01101001 10100110 ...
          </div>
        </div>
      </div>

    </div><!-- /hud-right -->

  </div><!-- /hud-main -->

  <!-- ══════════════════════════════════════════
       BOTTOM TICKER
  ══════════════════════════════════════════ -->
  <footer class="hud-bottom" style="border-color:var(--border);">
    <div class="pulse-dot flex-shrink-0"></div>
    <span class="font-orb text-[8px] tracking-widest flex-shrink-0" style="color:rgba(0,240,255,0.4)">DATALINK</span>
    <div class="w-px h-4 flex-shrink-0" style="background:var(--border)"></div>
    <div class="ticker-wrap flex-1 overflow-hidden">
      <div class="ticker-inner font-mono text-[9px]" style="color:rgba(0,240,255,0.35)">
        &nbsp;&nbsp;&nbsp;◈ STARDATE 2749.183 · SECTOR: ORION EXPANSE · HULL INTEGRITY 94% · SHIELDS 71% · WARP CORE NOMINAL &nbsp;&nbsp;&nbsp; ◈ CONTACT: UES CARDINAL ID-VERIFIED 4,200KM · CONTACT: UNKNOWN VESSEL DELTA-4 8,400KM HEADING 091° &nbsp;&nbsp;&nbsp; ◈ ANOMALY GRID-7C: QUANTUM FLUX +340% · NEXUS AI ANALYSIS IN PROGRESS &nbsp;&nbsp;&nbsp; ◈ STARBASE-19 ETA SD 2749.21 · PRIORITY ALPHA DIRECTIVE ACTIVE &nbsp;&nbsp;&nbsp; ◈ WEAPONS ARRAY OFFLINE GRID-4 · REPAIR CREW DISPATCHED · ETA 2.3 HOURS &nbsp;&nbsp;&nbsp; ◈ VORATH-CLASS WARBIRD DETECTED SECTOR BOUNDARY · WEAPONS HOT · THREAT LEVEL 9 OF 10 &nbsp;&nbsp;&nbsp; ◈ ALL CREW TO BATTLE STATIONS STANDBY &nbsp;&nbsp;&nbsp; ◈ STARDATE 2749.183 · SECTOR: ORION EXPANSE · HULL INTEGRITY 94% · SHIELDS 71% · WARP CORE NOMINAL &nbsp;&nbsp;&nbsp; ◈ CONTACT: UES CARDINAL ID-VERIFIED 4,200KM · CONTACT: UNKNOWN VESSEL DELTA-4 8,400KM HEADING 091° &nbsp;&nbsp;&nbsp;
      </div>
    </div>
    <div class="w-px h-4 flex-shrink-0" style="background:var(--border)"></div>
    <span class="font-orb text-[8px] flex-shrink-0" style="color:rgba(0,240,255,0.35)">NEXUS<span style="color:rgba(0,240,255,0.2)">://</span>7</span>
  </footer>

</div><!-- /hud-root -->

<script>
// ── CLOCK ──
function updateClock() {
  const now = new Date();
  document.getElementById('clock').textContent =
    now.toUTCString().slice(17, 25) + ' UTC';
}
setInterval(updateClock, 1000);
updateClock();

// ── MATRIX RAIN ──
(function() {
  const canvas = document.getElementById('matrixCanvas');
  const ctx = canvas.getContext('2d');
  let cols, drops;

  function resize() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
    cols  = Math.floor(canvas.width / 16);
    drops = Array(cols).fill(1);
  }

  resize();
  window.addEventListener('resize', resize);

  function draw() {
    ctx.fillStyle = 'rgba(2,6,9,0.06)';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#00f0ff';
    ctx.font = '12px "Share Tech Mono"';

    for (let i = 0; i < drops.length; i++) {
      const char = String.fromCharCode(0x30A0 + Math.random() * 96);
      ctx.fillText(char, i * 16, drops[i] * 16);
      if (drops[i] * 16 > canvas.height && Math.random() > 0.975) drops[i] = 0;
      drops[i]++;
    }
  }

  setInterval(draw, 50);
})();

// ── RADAR ──
(function() {
  const canvas = document.getElementById('radarCanvas');
  const dpr = window.devicePixelRatio || 1;

  function resize() {
    const rect = canvas.parentElement.getBoundingClientRect();
    canvas.width  = rect.width  * dpr;
    canvas.height = rect.height * dpr;
    canvas.style.width  = rect.width  + 'px';
    canvas.style.height = rect.height + 'px';
  }

  resize();

  const ctx = canvas.getContext('2d');
  ctx.scale(dpr, dpr);

  let angle = 0;

  const contacts = [
    { angle: 0.8,  dist: 0.35, type: 'friendly', label: 'CARDINAL' },
    { angle: 2.1,  dist: 0.60, type: 'unknown',  label: 'Δ4' },
    { angle: 4.4,  dist: 0.82, type: 'hostile',  label: 'VORATH' },
    { angle: 1.2,  dist: 0.22, type: 'friendly', label: 'PROBE-1' },
    { angle: 3.5,  dist: 0.48, type: 'neutral',  label: 'STA-19' },
    { angle: 5.1,  dist: 0.30, type: 'neutral',  label: 'CIV-A' },
    { angle: 0.3,  dist: 0.70, type: 'neutral',  label: 'CIV-B' },
    { angle: 2.8,  dist: 0.55, type: 'friendly', label: 'PROBE-2' },
    { angle: 4.0,  dist: 0.18, type: 'neutral',  label: 'DEBR' },
    { angle: 5.8,  dist: 0.65, type: 'neutral',  label: 'CIV-C' },
    { angle: 1.8,  dist: 0.88, type: 'neutral',  label: 'CIV-D' },
    { angle: 3.1,  dist: 0.92, type: 'hostile',  label: 'SCOUT' },
  ];

  const colors = { friendly: '#00ff41', neutral: '#ffaa00', hostile: '#ff003c', unknown: '#a855f7' };

  function draw() {
    const rect = canvas.parentElement.getBoundingClientRect();
    const W = rect.width, H = rect.height;
    const cx = W / 2, cy = H / 2;
    const R  = Math.min(W, H) * 0.42;

    ctx.clearRect(0, 0, W, H);

    // Background hex
    ctx.fillStyle = 'rgba(0,10,20,0.7)';
    ctx.fillRect(0, 0, W, H);

    // Grid rings
    for (let i = 1; i <= 4; i++) {
      ctx.beginPath();
      ctx.arc(cx, cy, R * i / 4, 0, Math.PI * 2);
      ctx.strokeStyle = `rgba(0,240,255,${0.06 + i * 0.02})`;
      ctx.lineWidth = 0.5;
      ctx.stroke();
    }

    // Grid lines
    for (let i = 0; i < 8; i++) {
      const a = i * Math.PI / 4;
      ctx.beginPath();
      ctx.moveTo(cx, cy);
      ctx.lineTo(cx + Math.cos(a) * R, cy + Math.sin(a) * R);
      ctx.strokeStyle = 'rgba(0,240,255,0.05)';
      ctx.lineWidth = 0.5;
      ctx.stroke();
    }

    // Sweep sector fill
    const sweepLen = Math.PI / 6;
    const grad = ctx.createConicalGradient
      ? null
      : null;

    ctx.beginPath();
    ctx.moveTo(cx, cy);
    ctx.arc(cx, cy, R, angle - sweepLen, angle);
    ctx.closePath();
    const grd = ctx.createRadialGradient(cx, cy, 0, cx, cy, R);
    grd.addColorStop(0, 'rgba(0,240,255,0.0)');
    grd.addColorStop(1, 'rgba(0,240,255,0.12)');
    ctx.fillStyle = grd;
    ctx.fill();

    // Sweep line
    ctx.beginPath();
    ctx.moveTo(cx, cy);
    ctx.lineTo(cx + Math.cos(angle) * R, cy + Math.sin(angle) * R);
    ctx.strokeStyle = 'rgba(0,240,255,0.8)';
    ctx.lineWidth = 1.5;
    ctx.shadowColor = 'rgba(0,240,255,0.5)';
    ctx.shadowBlur = 6;
    ctx.stroke();
    ctx.shadowBlur = 0;

    // Contacts
    contacts.forEach(c => {
      const a = c.angle;
      const d = c.dist * R;
      const x = cx + Math.cos(a) * d;
      const y = cy + Math.sin(a) * d;
      const col = colors[c.type] || '#00f0ff';

      // Ping trail
      ctx.beginPath();
      ctx.arc(x, y, 5, 0, Math.PI * 2);
      ctx.strokeStyle = col.replace(')', ', 0.2)').replace('rgb', 'rgba');
      ctx.lineWidth = 0.5;
      ctx.stroke();

      ctx.beginPath();
      ctx.arc(x, y, 2.5, 0, Math.PI * 2);
      ctx.fillStyle = col;
      ctx.shadowColor = col;
      ctx.shadowBlur = 8;
      ctx.fill();
      ctx.shadowBlur = 0;

      ctx.font = '8px "Share Tech Mono"';
      ctx.fillStyle = col;
      ctx.fillText(c.label, x + 5, y - 4);
    });

    // Center cross
    ctx.strokeStyle = 'rgba(0,240,255,0.5)';
    ctx.lineWidth = 1;
    [[-8,0,8,0],[0,-8,0,8]].forEach(([x1,y1,x2,y2]) => {
      ctx.beginPath();
      ctx.moveTo(cx+x1,cy+y1);
      ctx.lineTo(cx+x2,cy+y2);
      ctx.stroke();
    });

    // Center dot
    ctx.beginPath();
    ctx.arc(cx, cy, 3, 0, Math.PI * 2);
    ctx.fillStyle = '#00f0ff';
    ctx.shadowColor = '#00f0ff';
    ctx.shadowBlur = 12;
    ctx.fill();
    ctx.shadowBlur = 0;

    angle += 0.018;
    requestAnimationFrame(draw);
  }

  draw();
  window.addEventListener('resize', () => {
    resize();
    ctx.scale(dpr, dpr);
  });
})();

// ── TELEMETRY CHART ──
(function() {
  const gen = () => Array.from({length: 60}, (_,i) =>
    Math.sin(i * 0.4) * 30 + Math.sin(i * 0.9) * 15 + Math.random() * 12 + 50
  );

  const labels = Array.from({length: 60}, (_,i) => i);
  let d1 = gen(), d2 = gen(), d3 = gen();

  const chart = new Chart(document.getElementById('telemetryChart'), {
    type: 'line',
    data: {
      labels,
      datasets: [
        { data: d1, borderColor: '#00f0ff', borderWidth: 1, pointRadius: 0, tension: 0.4, fill: false },
        { data: d2, borderColor: '#00ff41', borderWidth: 1, pointRadius: 0, tension: 0.4, fill: false },
        { data: d3, borderColor: '#ffaa00', borderWidth: 0.7, borderDash:[3,2], pointRadius: 0, tension: 0.4, fill: false }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: false,
      plugins: { legend: { display: false }, tooltip: { enabled: false } },
      scales: {
        x: { display: false },
        y: {
          display: true,
          min: 0, max: 110,
          grid: { color: 'rgba(0,240,255,0.05)', drawTicks: false },
          border: { display: false },
          ticks: { color: 'rgba(0,240,255,0.3)', font: { family: 'Share Tech Mono', size: 8 }, maxTicksLimit: 5, callback: v => v + ' qF' }
        }
      }
    }
  });

  setInterval(() => {
    [d1, d2, d3].forEach(arr => {
      arr.shift();
      arr.push(Math.sin(Date.now() * 0.003 + arr.length) * 30 + Math.random() * 20 + 45);
    });
    chart.update('none');
  }, 120);
})();

// ── DATA STREAM SCRAMBLE ──
const chars = '01アイウエオカキクケコ01011010';
const el = document.getElementById('dataStream');
setInterval(() => {
  el.textContent = Array.from({length: 48}, () =>
    chars[Math.floor(Math.random() * chars.length)]
  ).join('') + ' ...';
}, 80);

// ── SHIELD FLUCTUATION ──
setInterval(() => {
  const v = (65 + Math.random() * 14).toFixed(0);
  const shieldEl = document.getElementById('shield-val');
  if (shieldEl) shieldEl.textContent = v + '%';
}, 2400);
</script>
</body>
</html>
