import React, { useState, useEffect, useRef } from 'react';
import * as THREE from 'three';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';
import '../../css/login-react.css';

gsap.registerPlugin(useGSAP);

export default function LoginApp({
  csrfToken = '',
  loginUrl = '/login',
  registerUrl = '/register',
  oldNik = '',
  errorMessage = null,
  successMessage = null,
}) {
  // Theme state: dark / light
  const [theme, setTheme] = useState(() => localStorage.getItem('masterip-theme') || 'dark');

  // Form states
  const [nik, setNik] = useState(oldNik);
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [capsLock, setCapsLock] = useState(false);
  const [isSubmitting, setIsSubmitting] = useState(false);

  // Security modal for EDP registration (@nt@riks@)
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [secPassword, setSecPassword] = useState('');
  const [secError, setSecError] = useState(false);

  // Transition screen state
  const [isTransitioning, setIsTransitioning] = useState(false);
  const [warpTransition, setWarpTransition] = useState(false);
  const [transitionUser, setTransitionUser] = useState('');
  const [authError, setAuthError] = useState(errorMessage);

  // Refs for GSAP & Three.js
  const containerRef = useRef(null);
  const canvasRef = useRef(null);
  const cardWrapRef = useRef(null);
  const loginCardRef = useRef(null);
  const brandIconRef = useRef(null);
  const brandTitleRef = useRef(null);
  const nikInputWrapRef = useRef(null);
  const passInputWrapRef = useRef(null);
  const nikLaserRef = useRef(null);
  const passLaserRef = useRef(null);
  const submitBtnRef = useRef(null);
  const modalOverlayRef = useRef(null);
  const modalBoxRef = useRef(null);
  const secInputRef = useRef(null);
  const veilRef = useRef(null);

  // Three.js internal controllers
  const threeControllersRef = useRef({
    triggerTypingPulse: () => {},
    triggerHyperspaceWarp: () => {},
    update3DTheme: () => {},
  });

  // Apply theme to document.body & localStorage
  useEffect(() => {
    document.body.classList.add('login-page-body');
    if (theme === 'light') {
      document.body.classList.add('theme-light');
    } else {
      document.body.classList.remove('theme-light');
    }
    localStorage.setItem('masterip-theme', theme);

    if (threeControllersRef.current.update3DTheme) {
      threeControllersRef.current.update3DTheme(theme);
    }
  }, [theme]);

  // Toggle Theme Handler
  const handleToggleTheme = () => {
    const nextTheme = theme === 'dark' ? 'light' : 'dark';
    setTheme(nextTheme);

    // GSAP Spin icon
    gsap.fromTo(
      '.theme-toggle-btn svg',
      { rotate: -180, scale: 0.6 },
      { rotate: 0, scale: 1, duration: 0.5, ease: 'back.out(2)' }
    );
  };

  // ══════════════════════════════════════════════════════════════
  // THREE.JS 3D CYBER ENGINE (EXACT MATCH FROM LOGIN.BLADE.PHP)
  // - Undulating Cyber Highway Terrain (moving forward like video)
  // - 3D Holographic Cyber Core (Geodesic Sphere + Octahedron + Torus Rings)
  // - 1,200+ Deep Space Starfield & Data Packets Streaming
  // - Interactive Mouse Dynamic Light & Camera Parallax
  // - Typing Pulse Energy (spins 4.5x faster on keyboard press)
  // ══════════════════════════════════════════════════════════════
  useEffect(() => {
    const canvas = canvasRef.current;
    if (!canvas) return;

    let renderer, scene, camera, animationFrameId;
    let clock = new THREE.Clock();
    let targetMouseX = 0, targetMouseY = 0;
    let curMouseX = 0, curMouseY = 0;
    let typingPulseEnergy = 0;
    let terrainOffset = 0;
    let isWarping = false;

    try {
      scene = new THREE.Scene();
      scene.fog = new THREE.FogExp2(theme === 'light' ? 0xedf2f9 : 0x030712, 0.028);

      camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
      camera.position.set(0, 4, 18);

      renderer = new THREE.WebGLRenderer({
        canvas: canvas,
        antialias: true,
        alpha: true,
        powerPreference: 'high-performance',
      });
      renderer.setSize(window.innerWidth, window.innerHeight);
      renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

      // Dynamic Lights
      const ambientLight = new THREE.AmbientLight(theme === 'light' ? 0x7788aa : 0x1e293b, 1.2);
      scene.add(ambientLight);

      const mouseLight = new THREE.PointLight(0x06b6d4, 2.5, 50);
      mouseLight.position.set(0, 5, 10);
      scene.add(mouseLight);

      const coreLight = new THREE.PointLight(0x6366f1, 3.0, 40);
      coreLight.position.set(0, 0, 0);
      scene.add(coreLight);

      // 1. 3D CYBER CORE (HOLOGRAPHIC GEODESIC SPHERE + ORBIT RINGS)
      const coreGroup = new THREE.Group();
      coreGroup.position.set(0, 0.5, 0);
      scene.add(coreGroup);

      const sphereGeo = new THREE.IcosahedronGeometry(4.2, 2);
      const sphereMat = new THREE.MeshBasicMaterial({
        color: theme === 'light' ? 0x4f46e5 : 0x6366f1,
        wireframe: true,
        transparent: true,
        opacity: 0.35,
      });
      const sphereMesh = new THREE.Mesh(sphereGeo, sphereMat);
      coreGroup.add(sphereMesh);

      const innerGeo = new THREE.OctahedronGeometry(2.0, 1);
      const innerMat = new THREE.MeshBasicMaterial({
        color: 0x06b6d4,
        wireframe: true,
        transparent: true,
        opacity: 0.7,
      });
      const innerMesh = new THREE.Mesh(innerGeo, innerMat);
      coreGroup.add(innerMesh);

      const ring1Geo = new THREE.TorusGeometry(5.2, 0.04, 16, 100);
      const ring1Mat = new THREE.MeshBasicMaterial({ color: 0x06b6d4, transparent: true, opacity: 0.6 });
      const ring1 = new THREE.Mesh(ring1Geo, ring1Mat);
      ring1.rotation.x = Math.PI / 3;
      coreGroup.add(ring1);

      const ring2Geo = new THREE.TorusGeometry(6.0, 0.03, 16, 100);
      const ring2Mat = new THREE.MeshBasicMaterial({ color: 0xa855f7, transparent: true, opacity: 0.45 });
      const ring2 = new THREE.Mesh(ring2Geo, ring2Mat);
      ring2.rotation.y = Math.PI / 4;
      ring2.rotation.x = -Math.PI / 5;
      coreGroup.add(ring2);

      // 2. UNDULATING 3D CYBER HIGHWAY (TERRAIN GRID LIKE VIDEO)
      const gridCols = 45;
      const gridRows = 45;
      const planeGeo = new THREE.PlaneGeometry(90, 90, gridCols, gridRows);
      planeGeo.rotateX(-Math.PI / 2);
      planeGeo.translate(0, -6.5, 0);

      const planeMat = new THREE.MeshBasicMaterial({
        color: theme === 'light' ? 0x6366f1 : 0x06b6d4,
        wireframe: true,
        transparent: true,
        opacity: theme === 'light' ? 0.22 : 0.35,
      });
      const terrainMesh = new THREE.Mesh(planeGeo, planeMat);
      scene.add(terrainMesh);

      const posAttr = planeGeo.attributes.position;
      const initialY = new Float32Array(posAttr.count);
      for (let i = 0; i < posAttr.count; i++) {
        initialY[i] = posAttr.getY(i);
      }

      // 3. 3D DEEP PARTICLE FIELD (1,200+ STARS & PACKETS)
      const particleCount = 1200;
      const particleGeo = new THREE.BufferGeometry();
      const particlePos = new Float32Array(particleCount * 3);
      const particleSpeeds = new Float32Array(particleCount);

      for (let i = 0; i < particleCount; i++) {
        particlePos[i * 3] = (Math.random() - 0.5) * 80;
        particlePos[i * 3 + 1] = (Math.random() - 0.5) * 60;
        particlePos[i * 3 + 2] = (Math.random() - 0.5) * 70;
        particleSpeeds[i] = 0.05 + Math.random() * 0.12;
      }
      particleGeo.setAttribute('position', new THREE.BufferAttribute(particlePos, 3));

      const particleMat = new THREE.PointsMaterial({
        size: 0.35,
        color: theme === 'light' ? 0x4f46e5 : 0x38bdf8,
        transparent: true,
        opacity: 0.7,
        blending: THREE.AdditiveBlending,
      });
      const particleSystem = new THREE.Points(particleGeo, particleMat);
      scene.add(particleSystem);

      // Mouse Tracking
      const handleMouseMove = (e) => {
        targetMouseX = (e.clientX / window.innerWidth) * 2 - 1;
        targetMouseY = -(e.clientY / window.innerHeight) * 2 + 1;
      };
      window.addEventListener('mousemove', handleMouseMove);

      // Resize Handler
      const handleResize = () => {
        if (!camera || !renderer) return;
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
      };
      window.addEventListener('resize', handleResize);

      // Scroll Momentum State for High-Speed Cyber Sphere Spin
      const scrollMomentum = {
        velocity: 0,
        targetVelocity: 0,
      };

      const handleWheel = (e) => {
        // Prevent default page scrolling so login card remains pinned in place
        if (e.cancelable) e.preventDefault();

        const delta = e.deltaY || 0;
        if (!delta) return;

        const direction = delta > 0 ? 1 : -1;
        const force = Math.min(Math.abs(delta) * 0.05, 8.0);

        scrollMomentum.targetVelocity += direction * force;
        // Clamp maximum spin speed
        scrollMomentum.targetVelocity = Math.max(-35, Math.min(35, scrollMomentum.targetVelocity));

        // GSAP: rapid acceleration with smooth inertial coasting and friction decay
        gsap.killTweensOf(scrollMomentum);
        gsap.to(scrollMomentum, {
          velocity: scrollMomentum.targetVelocity,
          duration: 0.12,
          ease: 'power1.out',
          onComplete: () => {
            // Natural inertia friction decay
            gsap.to(scrollMomentum, {
              velocity: 0,
              targetVelocity: 0,
              duration: 2.2,
              ease: 'power3.out',
            });
          },
        });

        // Micro dynamic shockwave on login card with GSAP
        if (loginCardRef.current) {
          gsap.to(loginCardRef.current, {
            scale: 0.985,
            borderColor: 'rgba(6, 182, 212, 0.75)',
            boxShadow: '0 30px 100px rgba(0, 0, 0, 0.9), 0 0 70px rgba(6, 182, 212, 0.4)',
            duration: 0.16,
            yoyo: true,
            repeat: 1,
            ease: 'sine.out',
          });
        }
      };

      // Wheel Listener on Window
      window.addEventListener('wheel', handleWheel, { passive: false });

      // Touch / Trackpad Swipe Support
      let touchStartY = 0;
      const handleTouchStart = (e) => {
        if (e.touches && e.touches[0]) {
          touchStartY = e.touches[0].clientY;
        }
      };
      const handleTouchMove = (e) => {
        if (e.touches && e.touches[0]) {
          const delta = touchStartY - e.touches[0].clientY;
          touchStartY = e.touches[0].clientY;
          handleWheel({ deltaY: delta * 2.5, cancelable: true, preventDefault: () => e.preventDefault() });
        }
      };
      window.addEventListener('touchstart', handleTouchStart, { passive: true });
      window.addEventListener('touchmove', handleTouchMove, { passive: false });

      // Animation Loop
      const animate = () => {
        animationFrameId = requestAnimationFrame(animate);
        const delta = clock.getDelta();
        const time = clock.getElapsedTime();

        // Smooth Mouse Lerp
        curMouseX += (targetMouseX - curMouseX) * 0.04;
        curMouseY += (targetMouseY - curMouseY) * 0.04;

        // Camera Parallax
        camera.position.x = curMouseX * 3.5;
        camera.position.y = 4 + curMouseY * 2.0;
        camera.lookAt(0, 0, 0);

        // Mouse Dynamic Light
        mouseLight.position.x = curMouseX * 12;
        mouseLight.position.y = curMouseY * 8 + 3;

        // 3D Core Rotation Driven by Normal Idle + Typing + GSAP Scroll Hyper-Spin!
        const v = scrollMomentum.velocity;
        const absV = Math.abs(v);
        const spinMult = 1.0 + typingPulseEnergy * 3.5;

        // High-Speed Spin on Geodesic Sphere and Orbit Rings
        coreGroup.rotation.y += (0.006 + v * 0.055) * spinMult;
        coreGroup.rotation.x += (0.003 + v * 0.030) * spinMult;
        ring1.rotation.z += (0.012 + v * 0.09) * spinMult;
        ring2.rotation.z -= (0.015 + v * 0.11) * spinMult;
        innerMesh.rotation.y -= (0.02 + v * 0.14) * spinMult;
        innerMesh.rotation.x += (v * 0.07) * spinMult;

        // Dynamic Centrifugal Scale Expansion during High-Speed Spin
        const centrifugalScale = 1 + Math.min(absV * 0.035, 0.4);
        sphereMesh.scale.setScalar(centrifugalScale * (1 + typingPulseEnergy * 0.15));
        innerMesh.scale.setScalar(1 + Math.min(absV * 0.05, 0.5));

        // Core Light Flares Brighter with High-Speed Spin
        coreLight.intensity = 3.0 + Math.min(absV * 1.6, 10.0);
        coreLight.distance = 40 + Math.min(absV * 8, 65);

        // Typing Pulse Decay
        if (typingPulseEnergy > 0) {
          typingPulseEnergy *= 0.94;
        }

        // Continuous Cyber Highway Wave (travels faster on scroll)
        terrainOffset += delta * (1.5 + Math.min(absV * 0.8, 6.5));
        const positions = planeGeo.attributes.position;
        for (let i = 0; i < positions.count; i++) {
          const x = positions.getX(i);
          const z = positions.getZ(i);
          const wave = Math.sin(x * 0.25 + time * 2.0) * Math.cos(z * 0.25 + terrainOffset) * 1.6;
          positions.setY(i, initialY[i] + wave);
        }
        positions.needsUpdate = true;

        // Particle Streaming (Hyperspace Warp Speed on Scroll or Warping)
        const warpFactor = isWarping
          ? 45.0
          : 1.0 + Math.min(absV * 1.0, 8.0) + typingPulseEnergy * 2;
        const pArr = particleGeo.attributes.position.array;
        for (let i = 0; i < particleCount; i++) {
          pArr[i * 3 + 2] += particleSpeeds[i] * warpFactor;
          if (pArr[i * 3 + 2] > 35) {
            pArr[i * 3 + 2] = -35;
          }
        }
        particleGeo.attributes.position.needsUpdate = true;

        if (isWarping) {
          coreGroup.rotation.y += 0.22;
          coreGroup.rotation.x += 0.12;
          ring1.rotation.z += 0.32;
          ring2.rotation.z -= 0.38;
          innerMesh.rotation.y += 0.45;
          terrainOffset += delta * 12.0;
        }

        renderer.render(scene, camera);
      };
      animate();

      // Controller Hookups
      threeControllersRef.current.triggerTypingPulse = () => {
        typingPulseEnergy = 1.0;
      };

      threeControllersRef.current.triggerHyperspaceWarp = () => {
        isWarping = true;
        // Fly camera forward right through the core
        gsap.to(camera.position, {
          z: -6,
          y: 0.5,
          duration: 1.25,
          ease: 'expo.in',
        });
        // Expand sphere to swallow screen
        gsap.to(coreGroup.scale, {
          x: 7.0,
          y: 7.0,
          z: 7.0,
          duration: 1.2,
          ease: 'power3.in',
        });
        // Core light flash
        gsap.to(coreLight, {
          intensity: 28,
          distance: 140,
          duration: 1.0,
          ease: 'power2.in',
        });
      };

      threeControllersRef.current.update3DTheme = (t) => {
        const isLight = t === 'light';
        if (scene.fog) scene.fog.color.setHex(isLight ? 0xedf2f9 : 0x030712);
        ambientLight.color.setHex(isLight ? 0x7788aa : 0x1e293b);
        planeMat.color.setHex(isLight ? 0x6366f1 : 0x06b6d4);
        planeMat.opacity = isLight ? 0.22 : 0.35;
        particleMat.color.setHex(isLight ? 0x4f46e5 : 0x38bdf8);
        sphereMat.color.setHex(isLight ? 0x4f46e5 : 0x6366f1);
      };

      return () => {
        cancelAnimationFrame(animationFrameId);
        window.removeEventListener('mousemove', handleMouseMove);
        window.removeEventListener('resize', handleResize);
        window.removeEventListener('wheel', handleWheel);
        window.removeEventListener('touchstart', handleTouchStart);
        window.removeEventListener('touchmove', handleTouchMove);
        if (renderer) renderer.dispose();
      };
    } catch (err) {
      console.warn('Three.js initialization failed, using 2D fallback:', err);
    }
  }, []);

  // ══════════════════════════════════════════════════════════════
  // GSAP ENTRANCE & TIMELINE ANIMATIONS (SUPERCHARGED)
  // ══════════════════════════════════════════════════════════════
  useGSAP(
    () => {
      const tl = gsap.timeline({ defaults: { ease: 'power4.out' } });

      // 1. 3D Card Elastic Flight Entrance
      tl.fromTo(
        loginCardRef.current,
        {
          y: 90,
          opacity: 0,
          scale: 0.88,
          rotateX: 25,
          filter: 'blur(8px)',
        },
        {
          y: 0,
          opacity: 1,
          scale: 1,
          rotateX: 0,
          filter: 'blur(0px)',
          duration: 1.25,
          clearProps: 'transform,filter',
        }
      )
        // 2. Corner brackets snapping in from 4 angles
        .fromTo(
          '.corner-tl',
          { x: -25, y: -25, opacity: 0 },
          { x: 0, y: 0, opacity: 0.6, duration: 0.45, ease: 'back.out(2)' },
          '-=0.8'
        )
        .fromTo(
          '.corner-tr',
          { x: 25, y: -25, opacity: 0 },
          { x: 0, y: 0, opacity: 0.6, duration: 0.45, ease: 'back.out(2)' },
          '-=0.8'
        )
        .fromTo(
          '.corner-bl',
          { x: -25, y: 25, opacity: 0 },
          { x: 0, y: 0, opacity: 0.6, duration: 0.45, ease: 'back.out(2)' },
          '-=0.8'
        )
        .fromTo(
          '.corner-br',
          { x: 25, y: 25, opacity: 0 },
          { x: 0, y: 0, opacity: 0.6, duration: 0.45, ease: 'back.out(2)' },
          '-=0.8'
        )
        // 3. Brand Logo 3D Spin & Bounce
        .fromTo(
          brandIconRef.current,
          { scale: 0, rotate: -60 },
          { scale: 1, rotate: 0, duration: 0.7, ease: 'back.out(1.8)' },
          '-=0.6'
        )
        // 4. Brand Title Reveal
        .fromTo(
          brandTitleRef.current,
          { opacity: 0, x: -15 },
          { opacity: 1, x: 0, duration: 0.5 },
          '-=0.5'
        )
        // 5. Staggered Form Groups
        .fromTo(
          '.gsap-form-item',
          { opacity: 0, y: 22, filter: 'blur(4px)' },
          { opacity: 1, y: 0, filter: 'blur(0px)', duration: 0.55, stagger: 0.09 },
          '-=0.4'
        )
        // 6. Submit Button Spring
        .fromTo(
          submitBtnRef.current,
          { opacity: 0, scale: 0.9, y: 15 },
          { opacity: 1, scale: 1, y: 0, duration: 0.5, ease: 'back.out(1.5)' },
          '-=0.2'
        );

      // Subtle breathing on Hologram Conic Halo
      gsap.to('.card-holo-glow', {
        opacity: 0.9,
        duration: 3,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut',
      });
    },
    { scope: containerRef }
  );

  // ══════════════════════════════════════════════════════════════
  // GSAP 3D MOUSE PARALLAX & TILT (60-120fps Smooth Damping)
  // ══════════════════════════════════════════════════════════════
  useEffect(() => {
    const cardWrap = cardWrapRef.current;
    if (!cardWrap) return;

    const setRotateX = gsap.quickTo(cardWrap, 'rotateX', { duration: 0.5, ease: 'power2.out' });
    const setRotateY = gsap.quickTo(cardWrap, 'rotateY', { duration: 0.5, ease: 'power2.out' });

    const handleTilt = (e) => {
      const { innerWidth, innerHeight } = window;
      const xNorm = (e.clientX / innerWidth) * 2 - 1;
      const yNorm = (e.clientY / innerHeight) * 2 - 1;

      // Subtle 3D tilt: max 11 deg
      setRotateY(xNorm * 11);
      setRotateX(-yNorm * 11);
    };

    const handleResetTilt = () => {
      setRotateX(0);
      setRotateY(0);
    };

    window.addEventListener('mousemove', handleTilt);
    document.addEventListener('mouseleave', handleResetTilt);

    return () => {
      window.removeEventListener('mousemove', handleTilt);
      document.removeEventListener('mouseleave', handleResetTilt);
    };
  }, []);

  // ══════════════════════════════════════════════════════════════
  // GSAP LASER FOCUS SCANNER BEAM
  // ══════════════════════════════════════════════════════════════
  const handleInputFocus = (field) => {
    const targetLaser = field === 'nik' ? nikLaserRef.current : passLaserRef.current;
    if (targetLaser) {
      gsap.fromTo(
        targetLaser,
        { width: '0%', left: '50%', opacity: 1 },
        { width: '100%', left: '0%', opacity: 1, duration: 0.45, ease: 'power3.out' }
      );
    }
  };

  const handleInputBlur = (field) => {
    const targetLaser = field === 'nik' ? nikLaserRef.current : passLaserRef.current;
    if (targetLaser) {
      gsap.to(targetLaser, {
        opacity: 0,
        duration: 0.3,
        onComplete: () => {
          gsap.set(targetLaser, { width: '0%', left: '50%' });
        },
      });
    }
  };

  // ══════════════════════════════════════════════════════════════
  // KEYBOARD PULSE & CAPSLOCK
  // ══════════════════════════════════════════════════════════════
  const handleKeyDownOrUp = (e) => {
    // Trigger Three.js pulse
    if (threeControllersRef.current.triggerTypingPulse) {
      threeControllersRef.current.triggerTypingPulse();
    }

    // Subtle GSAP flash on card border
    if (loginCardRef.current) {
      gsap.to(loginCardRef.current, {
        borderColor: 'rgba(6, 182, 212, 0.7)',
        duration: 0.1,
        yoyo: true,
        repeat: 1,
        ease: 'power1.out',
      });
    }

    // CapsLock Check
    if (e.getModifierState) {
      const isCaps = e.getModifierState('CapsLock');
      setCapsLock(isCaps);
    }
  };

  // ══════════════════════════════════════════════════════════════
  // FORM SUBMIT & HYPERSPACE WARP TRANSITION
  // ══════════════════════════════════════════════════════════════
  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!nik.trim() || !password.trim()) {
      if (loginCardRef.current) {
        gsap.fromTo(
          loginCardRef.current,
          { x: -14 },
          { x: 14, repeat: 5, yoyo: true, duration: 0.05, ease: 'power1.inOut' }
        );
      }
      return;
    }

    setIsSubmitting(true);
    setAuthError(null);

    // Button scale down click feedback
    if (submitBtnRef.current) {
      gsap.to(submitBtnRef.current, { scale: 0.98, duration: 0.1 });
    }

    try {
      const response = await fetch(loginUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
          NIK: nik.trim(),
          Password: password,
        }),
      });

      const data = await response.json().catch(() => ({}));

      if (!response.ok || !data.success) {
        setIsSubmitting(false);
        setAuthError(data.message || 'NIK atau Password salah. Silakan coba lagi.');
        if (loginCardRef.current) {
          gsap.fromTo(
            loginCardRef.current,
            { x: -16, borderColor: 'rgba(244, 63, 94, 0.85)' },
            { x: 16, repeat: 5, yoyo: true, duration: 0.05, ease: 'power1.inOut' }
          );
        }
        return;
      }

      // Authentication Success!
      const userName = data.user || 'USER';
      setTransitionUser(userName);
      setWarpTransition(true);

      // Store in sessionStorage so Dashboard can trigger entrance reveal
      sessionStorage.setItem('just_logged_in', '1');
      sessionStorage.setItem('logged_user_nama', userName);

      // 1. Trigger Three.js hyperspace flight into the core
      if (threeControllersRef.current.triggerHyperspaceWarp) {
        threeControllersRef.current.triggerHyperspaceWarp();
      }

      // 2. Animate card dissolving & zooming into the vortex
      if (loginCardRef.current) {
        gsap.to(loginCardRef.current, {
          scale: 0.72,
          opacity: 0,
          filter: 'blur(16px)',
          y: -35,
          duration: 0.75,
          ease: 'power3.in',
        });
      }

      // 3. Cyber Portal Transition Screen
      setTimeout(() => {
        if (veilRef.current) {
          gsap.fromTo(
            veilRef.current,
            { opacity: 0, scale: 0.95 },
            {
              opacity: 1,
              scale: 1,
              duration: 0.45,
              ease: 'power2.out',
            }
          );

          // Animate progress bar fill
          const fillBar = veilRef.current.querySelector('.veil-progress-bar-fill');
          if (fillBar) {
            gsap.fromTo(
              fillBar,
              { width: '0%' },
              {
                width: '100%',
                duration: 0.85,
                ease: 'power2.inOut',
                onComplete: () => {
                  window.location.href = data.redirect || '/dashboard';
                },
              }
            );
          } else {
            setTimeout(() => {
              window.location.href = data.redirect || '/dashboard';
            }, 900);
          }
        } else {
          window.location.href = data.redirect || '/dashboard';
        }
      }, 500);

    } catch (err) {
      console.error('Login error:', err);
      // Fallback: submit natively if network or unexpected fetch error
      const form = e.target;
      if (form && form.tagName === 'FORM') {
        form.submit();
      } else {
        window.location.href = loginUrl;
      }
    }
  };

  const handleBtnRipple = (e) => {
    const btn = submitBtnRef.current;
    if (!btn) return;
    const rect = btn.getBoundingClientRect();
    const ripple = document.createElement('span');
    ripple.className = 'btn-ripple';
    const size = Math.max(rect.width, rect.height);
    ripple.style.width = size + 'px';
    ripple.style.height = size + 'px';
    ripple.style.left = e.clientX - rect.left - size / 2 + 'px';
    ripple.style.top = e.clientY - rect.top - size / 2 + 'px';
    btn.appendChild(ripple);
    setTimeout(() => ripple.remove(), 650);
  };

  // ══════════════════════════════════════════════════════════════
  // REGISTER SECURITY MODAL (@nt@riks@) WITH GSAP SPRING
  // ══════════════════════════════════════════════════════════════
  const openRegisterModal = (e) => {
    e.preventDefault();
    setIsModalOpen(true);
    setSecError(false);
    setSecPassword('');

    // GSAP 3D Spring Reveal
    setTimeout(() => {
      if (modalBoxRef.current && modalOverlayRef.current) {
        gsap.fromTo(
          modalOverlayRef.current,
          { opacity: 0 },
          { opacity: 1, duration: 0.3 }
        );
        gsap.fromTo(
          modalBoxRef.current,
          { scale: 0.84, opacity: 0, y: 35, rotateX: 20 },
          { scale: 1, opacity: 1, y: 0, rotateX: 0, duration: 0.45, ease: 'back.out(1.6)' }
        );
        if (secInputRef.current) secInputRef.current.focus();
      }
    }, 10);
  };

  const closeRegisterModal = () => {
    if (modalBoxRef.current && modalOverlayRef.current) {
      gsap.to(modalBoxRef.current, {
        scale: 0.88,
        opacity: 0,
        y: 20,
        duration: 0.25,
        ease: 'power3.in',
      });
      gsap.to(modalOverlayRef.current, {
        opacity: 0,
        duration: 0.25,
        onComplete: () => setIsModalOpen(false),
      });
    } else {
      setIsModalOpen(false);
    }
  };

  const handleConfirmSecurityPass = () => {
    if (secPassword !== '@nt@riks@') {
      setSecError(true);
      // GSAP Shake modal on wrong password
      if (modalBoxRef.current) {
        gsap.fromTo(
          modalBoxRef.current,
          { x: -12 },
          { x: 12, repeat: 5, yoyo: true, duration: 0.06, ease: 'power1.inOut' }
        );
      }
      return;
    }

    // Success: Close modal and trigger transition veil to /register
    closeRegisterModal();
    setIsTransitioning(true);

    setTimeout(() => {
      if (veilRef.current) {
        gsap.fromTo(
          veilRef.current,
          { opacity: 0 },
          {
            opacity: 1,
            duration: 0.45,
            ease: 'power2.inOut',
            onComplete: () => {
              window.location.href = registerUrl;
            },
          }
        );
      } else {
        window.location.href = registerUrl;
      }
    }, 200);
  };

  return (
    <div ref={containerRef}>
      {/* ══ 3D WebGL Canvas Engine (Three.js with Fallback) ══ */}
      <canvas id="threejsCanvas" ref={canvasRef} />

      {/* ══ Cinematic Overlays ══ */}
      <div className="cinematic-glow" />
      <div className="cinematic-vignette" />
      <div className="scanline" />

      {/* ══ REGISTER SECURITY PASSWORD MODAL (@nt@riks@) ══ */}
      {isModalOpen && (
        <div
          id="regPasswordModal"
          className="open"
          ref={modalOverlayRef}
          onClick={(e) => {
            if (e.target === modalOverlayRef.current) closeRegisterModal();
          }}
        >
          <div className="modal-content-box" ref={modalBoxRef}>
            <div className="modal-top-beam" />
            <div className="modal-tag">OTORISASI AKSES TERBATAS</div>
            <div className="modal-title">Password Verifikasi EDP</div>
            <div className="modal-desc">
              Halaman pendaftaran pengguna baru dilindungi. Masukkan password security internal EDP untuk melanjutkan.
            </div>

            <div style={{ position: 'relative' }}>
              <svg
                style={{
                  position: 'absolute',
                  left: '13px',
                  top: '13px',
                  width: '16px',
                  height: '16px',
                  stroke: 'var(--text-dim)',
                }}
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="2"
                strokeLinecap="round"
                strokeLinejoin="round"
              >
                <rect x="3" y="11" width="18" height="11" rx="2" />
                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
              </svg>
              <input
                type="password"
                ref={secInputRef}
                className="modal-input-field"
                placeholder="••••••••"
                value={secPassword}
                onChange={(e) => {
                  setSecPassword(e.target.value);
                  setSecError(false);
                }}
                onKeyDown={(e) => {
                  if (e.key === 'Enter') handleConfirmSecurityPass();
                  if (e.key === 'Escape') closeRegisterModal();
                }}
              />
            </div>

            <div className={`modal-error-msg ${secError ? 'show' : ''}`}>
              ✕ Password verifikasi salah. Silakan coba kembali.
            </div>

            <div className="modal-btn-row">
              <button
                type="button"
                className="btn-modal-cancel"
                onClick={closeRegisterModal}
              >
                Batal
              </button>
              <button
                type="button"
                className="btn-modal-confirm"
                onClick={handleConfirmSecurityPass}
              >
                Konfirmasi →
              </button>
            </div>
          </div>
        </div>
      )}

      {/* ══ Page Transition Veil (For Register and Dashboard Navigation) ══ */}
      {(isTransitioning || warpTransition) && (
        <div id="pageTransitionVeil" className="active" ref={veilRef}>
          <div className="veil-portal-ring">
            <div className="veil-ring-outer" />
            <div className="veil-ring-inner" />
            <div className="veil-ring-core" />
          </div>

          {warpTransition && (
            <>
              <div className="veil-badge-auth">OTORISASI BERHASIL // ACCESS GRANTED</div>
              <div className="veil-user-welcome">Selamat Datang, {transitionUser}</div>
            </>
          )}

          <div className="veil-text">
            {warpTransition
              ? 'MENGHUBUNGKAN KE DASHBOARD MASTER IP...'
              : 'MENGHUBUNGKAN KE REGISTRASI...'}
          </div>

          {warpTransition && (
            <div className="veil-progress-bar-wrap">
              <div className="veil-progress-bar-fill" />
            </div>
          )}
        </div>
      )}

      {/* ══ MAIN INTERACTIVE 3D LOGIN CONTAINER ══ */}
      <div className="wrapper">
        <div className="card-3d-wrap" ref={cardWrapRef}>
          <div className="login-card" ref={loginCardRef}>
            <div className="card-holo-glow" />

            {/* Corner Cyberspace Accents */}
            <div className="corner corner-tl" />
            <div className="corner corner-tr" />
            <div className="corner corner-bl" />
            <div className="corner corner-br" />

            {/* Brand Header & Theme Toggle */}
            <div className="brand-header">
              <div className="brand-left">
                <div className="brand-icon-box" ref={brandIconRef} title="MasterIP Portal">
                  <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <rect x="2" y="3" width="20" height="14" rx="2" />
                    <path d="M8 21h8M12 17v4" />
                    <path d="M6 8h.01M6 11h.01" />
                    <rect x="10" y="7" width="8" height="6" rx="1" />
                  </svg>
                  <div className="brand-icon-ring" />
                </div>
                <div className="brand-title-wrap" ref={brandTitleRef}>
                  <div className="brand-name">MasterIP</div>
                  <div className="brand-sub">BY ZMIE_V1.0 BETA</div>
                </div>
              </div>

              <button
                type="button"
                className="theme-toggle-btn"
                onClick={handleToggleTheme}
                aria-label="Ganti Tema"
                title={theme === 'dark' ? 'Ganti ke Tema Terang' : 'Ganti ke Tema Gelap'}
              >
                {theme === 'dark' ? (
                  <svg
                    className="icon-moon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                  </svg>
                ) : (
                  <svg
                    className="icon-sun"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <circle cx="12" cy="12" r="5" />
                    <line x1="12" y1="1" x2="12" y2="3" />
                    <line x1="12" y1="21" x2="12" y2="23" />
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                    <line x1="1" y1="12" x2="3" y2="12" />
                    <line x1="21" y1="12" x2="23" y2="12" />
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
                  </svg>
                )}
              </button>
            </div>

            {/* Flash Messages */}
            {(authError || errorMessage) && (
              <div className="alert-box gsap-form-item">
                <svg
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                >
                  <circle cx="12" cy="12" r="10" />
                  <line x1="12" y1="8" x2="12" y2="12" />
                  <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <span>{authError || errorMessage}</span>
              </div>
            )}

            {successMessage && (
              <div className="alert-box alert-success gsap-form-item">
                <svg
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                >
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                  <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                <span>{successMessage}</span>
              </div>
            )}

            {/* Main Form */}
            <form
              method="POST"
              action={loginUrl}
              onSubmit={handleSubmit}
              autoComplete="on"
            >
              {/* CSRF Token */}
              <input type="hidden" name="_token" value={csrfToken} />

              {/* NIK Input */}
              <div className="form-group gsap-form-item">
                <label className="form-label" htmlFor="nik-input">
                  <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                  </svg>
                  <span>NIK Karyawan</span>
                </label>
                <div className="input-container" ref={nikInputWrapRef}>
                  <svg
                    className="input-icon-left"
                    viewBox="0 0 24 24"
                    fill="none"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                  </svg>
                  <input
                    type="text"
                    name="NIK"
                    id="nik-input"
                    className="form-input"
                    placeholder="Masukkan NIK Anda"
                    value={nik}
                    onChange={(e) => setNik(e.target.value)}
                    onFocus={() => handleInputFocus('nik')}
                    onBlur={() => handleInputBlur('nik')}
                    onKeyDown={handleKeyDownOrUp}
                    onKeyUp={handleKeyDownOrUp}
                    autoComplete="username"
                    spellCheck="false"
                    required
                    autoFocus
                  />
                  {/* GSAP Laser Accent Beam */}
                  <div className="laser-focus-beam" ref={nikLaserRef} />
                </div>
                <div className="nik-preview">
                  {nik ? `// VERIFIKASI IDENTITAS: ${nik}` : ''}
                </div>
              </div>

              {/* Password Input */}
              <div className="form-group gsap-form-item">
                <label className="form-label" htmlFor="pass-input">
                  <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <rect x="3" y="11" width="18" height="11" rx="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                  </svg>
                  <span>Password</span>
                </label>
                <div className="input-container" ref={passInputWrapRef}>
                  <svg
                    className="input-icon-left"
                    viewBox="0 0 24 24"
                    fill="none"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <rect x="3" y="11" width="18" height="11" rx="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                  </svg>
                  <input
                    type={showPassword ? 'text' : 'password'}
                    name="Password"
                    id="pass-input"
                    className="form-input"
                    style={{ paddingRight: '44px' }}
                    placeholder="••••••••"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    onFocus={() => handleInputFocus('pass')}
                    onBlur={() => handleInputBlur('pass')}
                    onKeyDown={handleKeyDownOrUp}
                    onKeyUp={handleKeyDownOrUp}
                    autoComplete="current-password"
                    required
                  />
                  {/* GSAP Laser Accent Beam */}
                  <div className="laser-focus-beam" ref={passLaserRef} />

                  <button
                    type="button"
                    className="eye-btn"
                    onClick={() => setShowPassword(!showPassword)}
                    tabIndex="-1"
                    title={showPassword ? 'Sembunyikan Password' : 'Lihat Password'}
                  >
                    {showPassword ? (
                      <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        strokeWidth="2"
                        strokeLinecap="round"
                        strokeLinejoin="round"
                      >
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                        <line x1="1" y1="1" x2="23" y2="23" />
                      </svg>
                    ) : (
                      <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        strokeWidth="2"
                        strokeLinecap="round"
                        strokeLinejoin="round"
                      >
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                      </svg>
                    )}
                  </button>
                </div>

                <div className={`capslock-box ${capsLock ? 'show' : ''}`}>
                  <svg
                    width="12"
                    height="12"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2.5"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <path d="M12 2L2 7l10 5 10-5-10-5z" />
                    <path d="M2 17l10 5 10-5" />
                    <path d="M2 12l10 5 10-5" />
                  </svg>
                  <span>CAPS LOCK AKTIF</span>
                </div>
              </div>

              {/* Submit Button */}
              <button
                type="submit"
                className={`btn-submit-login ${isSubmitting ? 'loading' : ''}`}
                ref={submitBtnRef}
                onClick={handleBtnRipple}
                disabled={isSubmitting}
              >
                <div className="login-spinner" />
                <span className="btn-text-content" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                  <svg
                    width="15"
                    height="15"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2.5"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                  >
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                    <polyline points="10 17 15 12 10 7" />
                    <line x1="15" y1="12" x2="3" y2="12" />
                  </svg>
                  <span>M A S U K</span>
                </span>
              </button>

              {/* Divider */}
              <div className="divider gsap-form-item">
                <span className="divider-line" />
                <span className="divider-text">atau</span>
                <span className="divider-line" />
              </div>

              {/* Register Button */}
              <a
                href={registerUrl}
                className="btn-to-register gsap-form-item"
                onClick={openRegisterModal}
              >
                <svg
                  width="14"
                  height="14"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2.2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                >
                  <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                  <circle cx="9" cy="7" r="4" />
                  <line x1="19" y1="8" x2="19" y2="14" />
                  <line x1="22" y1="11" x2="16" y2="11" />
                </svg>
                <span>Buat Akun Baru</span>
              </a>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}
