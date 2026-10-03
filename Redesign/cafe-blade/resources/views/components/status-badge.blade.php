@props(['status'])
<span class="{{ $status === 'ada' ? 'badge-ada' : 'badge-habis' }}">
  <span class="h-1.5 w-1.5 rounded-full {{ $status === 'ada' ? 'bg-[#3f5a43]' : 'bg-[#c2603a]' }}"></span>
  {{ $status === 'ada' ? 'Ada' : 'Habis' }}
</span>
