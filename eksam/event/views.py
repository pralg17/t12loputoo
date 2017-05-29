from django.shortcuts import render, get_object_or_404, redirect
from django.contrib.auth.decorators import login_required
from django.utils import timezone
from .models import Event
from .forms import EventForm


def event_list(request):
    """ Renders all events in a list """
    events = Event.objects.filter()

    return render(request, 'event/event_list.html', {'events': events})


def event_detail(request, pk):
    """ Redners event details  """
    event = get_object_or_404(Event, pk=pk)

    return render(request, 'event/event_detail.html', {'event': event})


@login_required
def event_new(request):
    """ Renders form for new event """
    if request.method == "POST":
        form = EventForm(request.POST)
        if form.is_valid():
            event = form.save(commit=False)
            event.author = request.user
            event.created_date = timezone.now()
            event.save()

            return redirect('event_detail', pk=event.pk)
    else:
        form = EventForm()

    return render(request, 'event/event_edit.html', {'form': form})


@login_required
def event_edit(request, pk):
    """ Renders view for event edit """
    post = get_object_or_404(Event, pk=pk)
    if request.method == "POST":
        form = EventForm(request.POST, instance=post)
        if form.is_valid():
            event = form.save(commit=False)
            event.author = request.user
            event.created = timezone.now()
            event.save()

            return redirect('event_detail', pk=event.pk)
    else:
        form = EventForm(instance=post)

    return render(request, 'event/event_edit.html', {'form': form})


@login_required
def event_remove(request, pk):
    """ Renders remove event """
    event = get_object_or_404(Event, pk=pk)
    event.delete()
    return redirect('event_list')