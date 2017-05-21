""" Django forms """
from django import forms

from .models import Event


class EventForm(forms.ModelForm):
    """ Form to create new events """
    class Meta:
        """ Tell Django which model should be used to create this form  """
        model = Event
        fields = ('title', 'descripton',)
