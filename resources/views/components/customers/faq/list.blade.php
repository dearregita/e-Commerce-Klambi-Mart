<div class="min-h-screen px-6 py-24 mx-auto divide-y max-w-7xl divide-gray-900/10 sm:py-32 lg:px-8 lg:py-40">
  <h2 class="text-5xl font-bold leading-10 tracking-tight text-gray-900">{{ $title }}</h2>
  @forelse ( $faqs as $faq )
  <dl class="mt-10 space-y-8 divide-y divide-gray-900/10">
    <div class="pt-8 lg:grid lg:grid-cols-12 lg:gap-8">
      <dt class="text-base font-semibold leading-7 text-gray-900 lg:col-span-5">
        {{ $faq->question }}
      </dt>
      <dd class="mt-4 lg:col-span-7 lg:mt-0">
        <p class="text-base leading-7 text-gray-600">
          {{ $faq->answer }}.</p>
      </dd>
    </div>
  </dl>
  @empty
    
  @endforelse
</div>