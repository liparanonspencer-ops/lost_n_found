<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex flex-col items-center justify-center bg-[#0f172a] px-4 py-12 relative overflow-hidden font-sans">
    
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full opacity-20 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-emerald-500 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-600 rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-2xl w-full z-10">
        <div class="text-center mb-10">
            <h2 class="text-white text-3xl font-black tracking-tight mb-2">Retrieval Verification</h2>
            <p class="text-slate-400 text-sm">Please wait while we prepare your secure digital pass.</p>
        </div>

        <div class="bg-slate-800/50 backdrop-blur-xl rounded-[2.5rem] border border-white/10 p-8 shadow-2xl mb-8 transition-all hover:border-emerald-500/30">
            <div class="flex flex-col md:flex-row gap-8 items-center">
                
                <div class="w-full md:w-1/2">
                    <div class="relative group rounded-3xl overflow-hidden shadow-lg border border-white/5 bg-[#161b22]">
                        <a href="https://www.apple.com/icloud/find-my/" target="_blank" class="block w-full h-64 relative overflow-hidden flex items-center justify-center">
                            
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="absolute w-32 h-32 bg-emerald-500/20 rounded-full animate-ping"></div>
                                <div class="absolute w-48 h-48 bg-emerald-500/10 rounded-full animate-[ping_3s_linear_infinite]"></div>
                            </div>

                            <img src="https://upload.wikimedia.org/wikipedia/commons/e/ed/Item_Tracker_Icon.svg" 
                                 class="relative z-10 w-28 h-28 object-contain transition-transform duration-700 group-hover:scale-110 drop-shadow-[0_0_20px_rgba(16,185,129,0.4)]" 
                                 alt="iCloud Find My Icon">
                            
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-20">
                                <span class="bg-white text-black text-[10px] font-bold px-4 py-1.5 rounded-full uppercase tracking-widest shadow-xl">
                                    Visit Official Site
                                </span>
                            </div>

                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-4 z-20">
                                <span class="bg-emerald-500/20 backdrop-blur-md text-[9px] text-emerald-400 px-2 py-0.5 rounded-full font-bold uppercase tracking-widest border border-emerald-500/30">
                                    Partner Ad
                                </span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="w-full md:w-1/2 text-left">
                    <h3 class="text-emerald-400 font-bold text-xl mb-3 leading-tight">
                        Lost your iPhone? <br><span class="text-white">Find it with iCloud.</span>
                    </h3>
                    <p class="text-slate-400 text-sm mb-6 leading-relaxed">
                        Setting up 'Find My' is the first thing you should do with your new device. Stay protected and secure.
                    </p>
                    <a href="https://www.apple.com/icloud/find-my/" target="_blank" class="inline-flex items-center text-xs font-bold text-emerald-400 uppercase tracking-widest hover:text-emerald-300 transition-colors group/link">
                        Learn More 
                        <svg class="w-4 h-4 ml-1 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center min-h-[200px]">
            <div id="loading-state" class="text-center transition-all duration-500">
                <div class="inline-flex items-center px-4 py-2 bg-slate-800/80 rounded-full border border-white/5 mb-4 shadow-xl backdrop-blur-md">
                    <span class="relative flex h-3 w-3 mr-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <p class="text-slate-300 text-xs font-bold uppercase tracking-widest">
                        Generating Pass in <span id="timer" class="text-white font-black ml-1 text-base">5</span>s
                    </p>
                </div>
            </div>

            <div id="print-card" class="hidden opacity-0 translate-y-10 transition-all duration-700 ease-out w-full max-w-sm">
                <div class="bg-emerald-600 p-0.5 rounded-[2.5rem] shadow-[0_20px_60px_rgba(16,185,129,0.3)]">
                    <div class="bg-[#0f172a] rounded-[2.4rem] p-8 text-center">
                        <div class="w-16 h-16 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h4 class="text-white font-bold text-xl mb-1 tracking-tight">Pass is Ready!</h4>
                        <p class="text-slate-400 text-[13px] mb-6 px-4 leading-relaxed">Your retrieval credentials have been securely generated and are ready for print.</p>
                        
                        <a href="<?php echo e(route('claims.print', $claim->id)); ?>" 
                           class="flex items-center justify-center w-full py-4 bg-emerald-500 hover:bg-emerald-400 text-[#0f172a] rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg transition-all active:scale-95 transform hover:-translate-y-1">
                            Proceed to Print QR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let timeLeft = 5;
    const timerElement = document.getElementById('timer');
    const loadingState = document.getElementById('loading-state');
    const printCard = document.getElementById('print-card');

    const countdown = setInterval(() => {
        timeLeft--;
        if(timerElement) timerElement.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            
            // Smoother disappearance
            loadingState.style.opacity = '0';
            loadingState.style.transform = 'scale(0.9) translateY(-10px)';
            
            setTimeout(() => {
                loadingState.classList.add('hidden');
                
                // Show Card
                printCard.classList.remove('hidden');
                
                // Trigger Floating Animation
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        printCard.classList.remove('opacity-0', 'translate-y-10');
                        printCard.classList.add('opacity-100', 'translate-y-0');
                    }, 50);
                });
            }, 500);
        }
    }, 1000);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/riku/Documents/laravel_poject/lost_n_found/resources/views/admin/claims/ads.blade.php ENDPATH**/ ?>