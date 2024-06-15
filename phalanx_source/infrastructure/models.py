from django.db import models

class UserConsent(models.Model):
    user = models.ForeignKey('auth.User', on_delete=models.CASCADE)
    consent_date = models.DateTimeField(auto_now_add=True)
    consent_given = models.BooleanField(default=False)
