<div class="max-w-5xl mx-auto px-4 py-10 text-[#2e2d55] space-y-16">
    <div class="text-center">
        <h1 class="text-5xl font-extrabold">Bienvenido a Ludus Alea</h1>
    </div>

    <div class="bg-[#f6d6ba]/70  p-8 rounded-xl shadow-xl">
        <h2 class="text-4xl font-bold mb-4 text-center">Sobre Nosotros</h2>
        <p class="text-lg leading-relaxed text-center">
            Ludus Alea es una asociación cultural en Martos dedicada al mundo del ocio alternativo. Nuestro espacio reúne a personas con intereses comunes en juegos de rol, wargames, juegos de cartas y rol en vivo. Fomentamos la creatividad, la estrategia y la convivencia a través de actividades periódicas y eventos temáticos abiertos a socios y visitantes. Creemos en el poder del juego como herramienta de unión y crecimiento personal.
        </p>
    </div>

    <div class="md:flex md:space-x-8 space-y-8 md:space-y-0 justify-center items-start">
        <div class="bg-white/80  px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 rounded-lg w-full md:w-1/2">
            <div class="flex flex-col items-center">
                <h2 class="text-center text-3xl font-bold tracking-tight md:text-5xl">FAQ</h2>
                <p class="mt-3 text-lg text-neutral-500 md:text-xl text-center">Preguntas frecuentes</p>
            </div>
            <div class="mt-8 divide-y divide-neutral-200 space-y-4">

                <div class="py-2">
                    <details class="group">
                        <summary class="flex cursor-pointer items-center justify-between font-medium">
                            <span>¿Qué es el rol?</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-neutral-600">El rol es un juego narrativo donde interpretas personajes en una historia.</p>
                    </details>
                </div>

                <div class="py-2">
                    <details class="group">
                        <summary class="flex cursor-pointer items-center justify-between font-medium">
                            <span>¿Qué actividades realizamos?</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <div class="mt-3 text-neutral-600">
                            <div id="custom-carousel" class="relative w-full h-[300px]">
                                <div class="carousel relative h-3/4 overflow-hidden rounded-xl shadow-lg" id="carousel-body">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="carousel-slide absolute inset-0 transition-opacity duration-700 ease-in-out opacity-0 {{ $i === 1 ? 'opacity-100 z-10' : 'z-0' }}">
                                            <div class="flex justify-center items-center h-full">
                                                <img src="{{ asset($i . '.jpg') }}" alt="Imagen {{ $i }}"
                                                     class="object-contain h-full w-full rounded-xl bg-white p-4" />
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <div class="flex gap-2 justify-center mt-4 overflow-x-auto px-4" id="carousel-thumbnails">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <img src="{{ asset($i . '.jpg') }}"
                                             class="carousel-thumb w-24 h-16 object-contain rounded opacity-50 cursor-pointer border-2 border-transparent hover:opacity-80 bg-white"
                                             data-index="{{ $i - 1 }}"
                                             alt="Miniatura {{ $i }}">
                                    @endfor
                                </div>
                                <button onclick="moveSlide(-1)" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md z-20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#2e2d55]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button onclick="moveSlide(1)" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md z-20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#2e2d55]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </details>
                </div>
                

                <div class="py-2">
                    <details class="group">
                        <summary class="flex cursor-pointer items-center justify-between font-medium">
                            <span>¿Dónde nos encontramos?</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <div class="mt-3">
                            <div class="rounded-xl overflow-hidden shadow-md aspect-video">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3189.3008372743843!2d-3.9697605240948985!3d37.7280328167298!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6cfa510bc90b8f%3A0x9d94cb2081322b08!2sC.%20Campi%C3%B1a%2C%2066%2C%2023600%20Martos%2C%20Ja%C3%A9n!5e0!3m2!1ses!2ses!4v1715581845346!5m2!1ses!2ses"
                                    width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                                </iframe>
                            </div>
                        </div>
                    </details>
                </div>

                <div class="py-2">
                    <details class="group">
                        <summary class="flex cursor-pointer items-center justify-between font-medium">
                            <span>¿Cuánto vale ser socio?</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-neutral-600">10 € mensuales para socios semi, 25 € para socios completos.</p>
                    </details>
                </div>
                  <div class="py-2">
                    <details class="group">
                        <summary class="flex cursor-pointer items-center justify-between font-medium">
                            <span>¿Qué diferencia hay entre ser semi socio y entero?</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-neutral-600">Los socios enteros poseen llaves del local, los semis no</p>
                    </details>
                </div>

                <div class="py-2">
                    <details class="group">
                        <summary class="flex cursor-pointer items-center justify-between font-medium">
                            <span>¿Necesito algo para participar?</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="mt-3 text-neutral-600">El local dispone de una colección prestada de juegos de mesa y manuales de rol que cualquier socio puede usar.
                            Si no tienes tu propio mazo de Magics o tu ejercito de Warhammer algún socio te lo podrá prestar. </p>
                    </details>
                </div>

                <div class="py-2">
    <details class="group">
        <summary class="flex cursor-pointer items-center justify-between font-medium">
            <span>¿Qué no se tolera?</span>
            <span class="transition group-open:rotate-180">
                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round"
                     stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                    <path d="M6 9l6 6 6-6"></path>
                </svg>
            </span>
        </summary>
        <div class="mt-3 text-neutral-600 group-open:animate-fadeIn">
            <p class="mb-2">En Ludus Alea no se toleran:</p>
            <ul class="list-disc list-inside space-y-1 pl-2">
                <li>Conductas homófobas, machistas o racistas
                <li>Actitudes violentas hacia otros socios</li>
                <li>Ensuciar y no cuidar el local </li>
                <li> No pagar antés del día 15 de cada mes</li>
                <li> No cuidar los bienes comunes o sacarlos fuera</li>
                <li> Fumar en el interior o la introducción de cualquier estupefaciente</li>
            </ul>
            
        </div>
    </details>
</div>

                
            </div>
        </div>
        

        <div class="bg-white/80  border rounded-lg p-8 shadow w-full md:w-1/2 h-fit">
            <h2 class="title-font mb-1 text-lg font-medium text-gray-900">Contacto</h2>
            <p class="mb-5 leading-relaxed text-gray-600">¿Tienes dudas o sugerencias? ¡Escríbenos!</p>
            <form action="{{ route('contacto.enviar') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="text-sm leading-7 text-gray-600">Email</label>
                    <input type="email" id="email" name="email" required
                           class="w-full rounded border border-gray-300 bg-white py-1 px-3 text-base leading-8 text-gray-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>
                <div class="mb-4">
                    <label for="message" class="text-sm leading-7 text-gray-600">Mensaje</label>
                    <textarea id="message" name="message" required
                              class="h-32 w-full resize-none rounded border border-gray-300 bg-white py-1 px-3 text-base leading-6 text-gray-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"></textarea>
                </div>
                <button type="submit"
                        class="rounded bg-indigo-500 py-2 px-6 text-lg text-white hover:bg-indigo-600">Enviar</button>
            </form>
            <p class="mt-3 text-xs text-gray-500">Te responderemos lo antes posible.</p>
        </div>
    </div>
</div>
<script>
    let currentIndex = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const thumbs = document.querySelectorAll('.carousel-thumb');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('opacity-100', 'z-10');
            slide.classList.add('opacity-0', 'z-0');
            if (i === index) {
                slide.classList.add('opacity-100', 'z-10');
                slide.classList.remove('opacity-0', 'z-0');
            }
        });

        thumbs.forEach((thumb, i) => {
            thumb.classList.remove('opacity-100', 'border-[#2e2d55]');
            thumb.classList.add('opacity-50');
            if (i === index) {
                thumb.classList.remove('opacity-50');
                thumb.classList.add('opacity-100', 'border-[#2e2d55]');
            }
        });

        currentIndex = index;
    }

    function moveSlide(direction) {
        let newIndex = currentIndex + direction;
        if (newIndex < 0) newIndex = slides.length - 1;
        if (newIndex >= slides.length) newIndex = 0;
        showSlide(newIndex);
    }

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', () => {
            const index = parseInt(thumb.dataset.index);
            showSlide(index);
        });
    });

    setInterval(() => moveSlide(1), 6000);
</script>

