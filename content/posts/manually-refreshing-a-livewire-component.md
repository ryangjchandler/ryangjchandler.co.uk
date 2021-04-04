---
slug: manually-refreshing-a-livewire-component
title: 'Manually Refreshing a Livewire Component'
excerpt: 'Livewire provides a clean API for automatically polling and refreshing a component, but what if you want to manually refresh a component?'
published_at: 2020-06-10T11:00:00+00:00
---
Livewire's polling API is great for periodically refreshing your component or invoking an action, but one of the more quietly documented features is the ability to manually refresh a component using a "magic" action.

Here's how:

```
<div>
    <button wire:click="$refresh">Reload Component</button>
</div>
```

And that is it! The "magic" `$refresh` action can be used, anywhere an action can, in your component. Livewire will pick up the action name and simply re-render the component.