from django.db import models


# Create your models here.
from django.utils import timezone


class Content(models.Model):
	user = models.ForeignKey("auth.User")
	Tekst = models.TextField(default="")
	n_gram = models.IntegerField()
	created = models.DateTimeField(default=timezone.now)

	def __str__(self):
		return self.user + "_" + self.created
