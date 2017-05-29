from django.db import models
from django.utils import timezone
from geoposition.fields import GeopositionField

# Create your models here.

class Event(models.Model):
    author = models.ForeignKey('auth.User')
    members = models.TextField()
    title = models.CharField(
        max_length=400)
    description = models.TextField()
    location = models.CharField(max_length=100)
    position = GeopositionField(52.522906, 13.41156)
    created = models.DateTimeField(
        default=timezone.now)
    event_date = models.DateTimeField(
        blank=True, null=True)
    register_limit_date = models.DateField(
        blank=True, null=True)

    def publish(self):
        self.created = timezone.now()
        self.save()

    def __str__(self):
        return self.title