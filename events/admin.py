""" To make our models visible on the admin page """
from django.contrib import admin
from .models import Event

admin.site.register(Event)
